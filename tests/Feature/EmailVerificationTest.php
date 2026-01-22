<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test mengirim OTP untuk authenticated user
     */
    public function test_send_otp_to_authenticated_user(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'is_verified' => false,
        ]);

        $this->actingAs($user)
            ->postJson('/send-otp-auth')
            ->assertJson([
                'success' => true,
            ]);

        Mail::assertSent(SendOtpMail::class);
    }

    /**
     * Test cooldown saat mengirim ulang OTP
     */
    public function test_cooldown_for_resend_otp(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'is_verified' => false,
        ]);

        // OTP pertama dikirim
        $this->actingAs($user)
            ->postJson('/send-otp-auth')
            ->assertJson(['success' => true]);

        // Coba kirim ulang segera
        $this->actingAs($user)
            ->postJson('/send-otp-auth')
            ->assertJson([
                'success' => false,
                'message' => 'Tunggu 60 detik sebelum mengirim ulang OTP.'
            ]);
    }

    /**
     * Test verifikasi OTP yang benar
     */
    public function test_verify_correct_otp(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'is_verified' => false,
        ]);

        // Generate OTP
        $otp = '123456';
        $user->otp_code = bcrypt($otp);
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        // Verify OTP
        $response = $this->actingAs($user)
            ->postJson('/verify-email-auth', [
                'otp' => $otp,
            ]);

        $response->assertJson([
            'success' => true,
            'message' => 'Email berhasil diverifikasi!'
        ]);

        // Periksa pengguna sudah diverifikasi
        $this->assertTrue($user->fresh()->is_verified);
    }

    /**
     * Test verifikasi OTP yang salah
     */
    public function test_verify_wrong_otp(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'is_verified' => false,
        ]);

        // Generate OTP
        $otp = '123456';
        $user->otp_code = bcrypt($otp);
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        // Try to verify with wrong OTP
        $response = $this->actingAs($user)
            ->postJson('/verify-email-auth', [
                'otp' => '000000',
            ]);

        $response->assertJson([
            'success' => false,
            'message' => 'Kode OTP salah.'
        ]);

        // Periksa pengguna belum diverifikasi
        $this->assertFalse($user->fresh()->is_verified);
    }

    /**
     * Test verifikasi OTP yang expired
     */
    public function test_verify_expired_otp(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'is_verified' => false,
        ]);

        // Generate OTP yang sudah expired
        $otp = '123456';
        $user->otp_code = bcrypt($otp);
        $user->otp_expires_at = now()->subMinutes(1); // Sudah expired 1 menit lalu
        $user->save();

        // Try to verify
        $response = $this->actingAs($user)
            ->postJson('/verify-email-auth', [
                'otp' => $otp,
            ]);

        $response->assertJson([
            'success' => false,
            'message' => 'Kode OTP sudah kedaluwarsa.'
        ]);

        // Periksa pengguna belum diverifikasi
        $this->assertFalse($user->fresh()->is_verified);
    }

    /**
     * Test myprofile page show verify button
     */
    public function test_myprofile_show_verify_button(): void
    {
        $user = User::factory()->create([
            'is_verified' => false,
        ]);

        $response = $this->actingAs($user)->get('/myprofile');
        $response->assertStatus(200);
        $response->assertSee('Verifikasi Email');
        $response->assertSee('Verifikasi');
    }

    /**
     * Test myprofile page hide verify button for verified user
     */
    public function test_myprofile_hide_verify_button_for_verified_user(): void
    {
        $user = User::factory()->create([
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/myprofile');
        $response->assertStatus(200);
        $response->assertSee('Terverifikasi');
    }

    /**
     * Test unauthenticated user cannot access send-otp-auth
     */
    public function test_unauthenticated_user_cannot_send_otp_auth(): void
    {
        $response = $this->postJson('/send-otp-auth');
        $response->assertStatus(401); // Unauthorized
    }

    /**
     * Test validation for OTP field
     */
    public function test_otp_validation(): void
    {
        $user = User::factory()->create([
            'is_verified' => false,
        ]);

        // Missing OTP
        $response = $this->actingAs($user)
            ->postJson('/verify-email-auth');
        $response->assertStatus(422);

        // OTP tidak 6 digit
        $response = $this->actingAs($user)
            ->postJson('/verify-email-auth', [
                'otp' => '12345', // Hanya 5 digit
            ]);
        $response->assertStatus(422);

        // OTP bukan numeric
        $response = $this->actingAs($user)
            ->postJson('/verify-email-auth', [
                'otp' => 'abcdef',
            ]);
        $response->assertStatus(422);
    }
}

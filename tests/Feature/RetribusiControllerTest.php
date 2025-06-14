<?php

use App\Models\User;
use App\Models\Pasar;
use App\Models\Retribusi;
use Illuminate\Support\Facades\Hash;


// Pengujian untuk memastikan pengguna yang tidak terautentikasi tidak dapat mengakses halaman retribusi
test('pengguna tidak login,tidak bisa akses sistem', function () {
    $response = $this->get(route('retribusi.index'));
    $response->assertStatus(404);
});

// Pengujian untuk admin yang dapat melihat semua retribusi
test('admin dapat melihat semua retribusi', function () {
    
    $pasar = Pasar::factory()->create();

    // Membuat user admin
    $user = User::factory()->create([
        'password' => Hash::make('password'),
        'operator' => $pasar->nama,
        'is_admin' => true,
        'pasar_id' => $pasar->id
    ]);
    

    $response = $this->get(route('retribusi.index'));

    $response->assertStatus(200);
});

// Pengujian untuk operator yang hanya dapat melihat retribusi dari pasar mereka
test('operator hanya bisa melihat retribusi pasarnya', function () {
    $pasar = Pasar::factory()->create();

    // Membuat user operator
    $user = User::factory()->create();

    // Membuat retribusi terkait dengan pasar operator
    $retribusiOperator = Retribusi::factory()->count(3)->create([
        'pasar_id' => $pasar->id
    ]);

    // Membuat retribusi untuk pasar lain
    Retribusi::factory()->count(2)->create();

    // Akses endpoint dengan operator
    $response = $this->actingAs($user)->get(route('retribusi.index'));

    $response->assertStatus(200);

    // Pastikan hanya retribusi dari pasar operator yang terlihat
    $response->assertViewHas('retribusi', function ($viewRetribusi) use ($retribusiOperator) {
        return $viewRetribusi->count() === $retribusiOperator->count() &&
               $viewRetribusi->pluck('id')->diff($retribusiOperator->pluck('id'))->isEmpty();
    });
});


// Pengujian untuk menyimpan retribusi baru
test('data retribusi bisa ditambahkan', function () {
    $pasar = Pasar::factory()->create();

    // Membuat user operator
    $user = User::factory()->create();

    $retribusi = Retribusi::factory()->create();

    $retribusiData = [
        'pasar_id' => $pasar->id,
        'user_id' => $user->id,
        'nama_pedagang' => $retribusi->nama_pedagang,
        'alamat' => $retribusi->alamat,
        'jenis_retribusi' => 'Parkir',
        'jumlah_pembayaran' => 50000,
        'metode_pembayaran' => 'Tunai',
        'gambar' => $retribusi->gambar,
        'keterangan' => 'Lunas'
    ];
    

    $response = $this->actingAs($user)->post(route('retribusi.store',$retribusiData));
    $response->assertStatus(302);
    // Memastikan respons redirect ke halaman yang benar 
    $response->assertRedirect(route('retribusi.index'));

    // Memastikan data berhasil tersimpan di database
    $this->assertDatabaseHas('retribusis', [
        'pasar_id' => $pasar->id,
        'user_id' => $user->id,
        'nama_pedagang' => $retribusi->nama_pedagang,
        'alamat' => $retribusi->alamat,
        'jenis_retribusi' => 'Parkir',
        'jumlah_pembayaran' => 50000,
        'metode_pembayaran' => 'Tunai',
        'gambar' => $retribusi->gambar,
        'keterangan' => 'Lunas'
      ]);
});

// Pengujian untuk memperbarui retribusi
test('data retribusi bisa diperbarui', function () {
    $pasar = Pasar::factory()->create();

    // Membuat user operator
    $user = User::factory()->create();

    $retribusi = Retribusi::factory()->create();

    $updatedData = [
        'pasar_id' => $pasar->id,
        'user_id' => $user->id,
        'nama_pedagang' => $retribusi->nama_pedagang,
        'alamat' => $retribusi->alamat,
        'jenis_retribusi' => 'Kebersihan',
        'jumlah_pembayaran' => 7500,
        'metode_pembayaran' => 'Transfer Bank',
        'keterangan' => 'Lunas'
    ];
    
    $response = $this->actingAs($user)->put(route('retribusi.update',$retribusi),$updatedData);
    
    $response->assertStatus(302);
    // Memastikan respons redirect ke halaman yang benar 
    $response->assertRedirect(route('retribusi.index'));

       // Memastikan data berhasil tersimpan di database
       $this->assertDatabaseHas('retribusis', [
        'pasar_id' => $pasar->id,
        'user_id' => $user->id,
        'nama_pedagang' => $retribusi->nama_pedagang,
        'alamat' => $retribusi->alamat,
        'jenis_retribusi' => 'Parkir',
        'jumlah_pembayaran' => 50000,
        'metode_pembayaran' => 'Tunai',
        'gambar' => $retribusi->gambar,
        'keterangan' => 'Lunas'
      ]);
});

// Pengujian untuk menghapus retribusi
test('data retribusi bisa dihapus', function () {
    $pasar = Pasar::factory()->create();

    // Membuat user operator
    $user = User::factory()->create();
    $retribusi = Retribusi::factory()->create();
    

    $response = $this->actingAs($user)->delete(route('retribusi.destroy', $retribusi));
 
    // Memastikan respons redirect ke halaman yang benar 
    $response->assertStatus(302);
    $response->assertRedirect(route('retribusi.index'));
   
    $this->assertDatabaseMissing('retribusis',[
        'id' => $retribusi->id,
    ]);
});

// Pengujian untuk ekspor retribusi oleh admin
test('admin bisa ekspor semua data retribusi', function () {
    $pasar = Pasar::factory()->create();

    // Membuat user admin
    $user = User::factory()->create();

    $date = now()->format('Y-m-d');

    $response = $this->actingAs($user)->get("/export-retribusi?date={$date}");

      // Membuat instance request
      $request = new \Illuminate\Http\Request();

      // Melakukan permintaan ekspor
      $response = $this->get('/export-retribusi', $request->toArray());

      // Memeriksa bahwa respons adalah instance dari Excel download
      $response->assertStatus(200);
      $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
});

// Pengujian untuk ekspor retribusi oleh operator hanya untuk pasar mereka
test('operator hanya bisa ekspor data berdasarkan pasarnya', function () {
   
    $pasar = Pasar::factory()->create();

    // Membuat user operator
    $user = User::factory()->create();

    $date = now()->format('Y-m-d');

    $response = $this->actingAs($user)->get("/export-retribusi?date={$date}");

     // Membuat instance request
    $request = new \Illuminate\Http\Request();

    
    // Melakukan permintaan ekspor
    $response = $this->get('/export-retribusi', $request->toArray());

    // Memeriksa bahwa respons adalah instance dari Excel download
    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
});

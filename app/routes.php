<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    // get
    $app->get('/Pelanggan', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL GetPelanggan()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    $app->get('/Produk', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL GetProduk');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    $app->get('/Pesanan', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL GetPesanan');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    $app->get('/DetailPesanan', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL GetDetailPesanan');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    // get by id
    $app->get('/pelanggan/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL GetPelangganByID(:id_pelanggan)');
        $query->execute([$args['id']]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results[0]));

        return $response->withHeader("Content-Type", "application/json");
    });

    $app->get('/produk/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL GetProdukByID(:id_produk)');
        $query->execute([$args['id']]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results[0]));

        return $response->withHeader("Content-Type", "application/json");
    });

    $app->get('/pesanan/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL GetPesananByID(:id_pesanan)');
        $query->execute([$args['id']]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results[0]));

        return $response->withHeader("Content-Type", "application/json");
    });

    $app->get('/detail_pesanan/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL GetDetailPesananByID(:id_detail_pesanan)');
        $query->execute([$args['id']]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results[0]));

        return $response->withHeader("Content-Type", "application/json");
    });

    // post data
    $app->post('/CreatePelanggan', function (Request $request, Response $response) {
        $data = $request->getParsedBody();

        $id_pelanggan = $data["id_pelanggan"];
        $nama_pelanggan = $data["nama_pelanggan"]; // menambah dengan kolom baru
        $alamat = $data["alamat"];
        $no_telepon = $data["no_telepon"];

        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL CreatePelanggan(:id_pelanggan, :nama_pelanggan, :alamat, :no_telepon)');
        $query->bindParam(':id_pelanggan', $id_pelanggan, PDO::PARAM_INT);
        $query->bindParam(':nama_pelanggan', $nama_pelanggan, PDO::PARAM_STR);
        $query->bindParam(':alamat', $alamat, PDO::PARAM_STR);
        $query->bindParam(':no_telepon', $no_telepon, PDO::PARAM_STR);

        // urutan harus sesuai dengan values
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Data Pelanggan Berhasil Dibuat']));
    
        return $response;
    });

    $app->post('/CreateProduk', function (Request $request, Response $response) {
        $data = $request->getParsedBody();

        $id_produk = $data["id_produk"];
        $nama_produk = $data["nama_produk"]; // menambah dengan kolom baru
        $harga = $data["harga"];
        $stok = $data["stok"];

        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL CreateProduk(:id_produk, :nama_produk, :harga, :stok)');
        $query->bindParam(':id_produk', $id_produk, PDO::PARAM_INT);
        $query->bindParam(':nama_produk', $nama_produk, PDO::PARAM_STR);
        $query->bindParam(':harga', $harga, PDO::PARAM_INT);
        $query->bindParam(':stok', $stok, PDO::PARAM_INT);

        // urutan harus sesuai dengan values
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Data Produk Berhasil Dibuat']));
    
        return $response;
    });

    $app->post('/CreatePesanan', function (Request $request, Response $response) {
        $data = $request->getParsedBody();

        $id_pesanan = $data["id_pesanan"];
        $tanggal_pesanan = $data["tanggal_pesanan"]; // menambah dengan kolom baru
        $id_pelanggan = $data["id_pelanggan"];
        $total_harga = $data["total_harga"];

        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL CreatePesanan(:id_pesanan, :tanggal_pesanan, :id_pelanggan, :total_harga)');
        $query->bindParam(':id_pesanan', $id_pesanan, PDO::PARAM_INT);
        $query->bindParam(':tanggal_pesanan', $tanggal_pesanan, PDO::PARAM_STR);
        $query->bindParam(':id_pelanggan', $id_pelanggan, PDO::PARAM_INT);
        $query->bindParam(':total_harga', $total_harga, PDO::PARAM_INT);

        // urutan harus sesuai dengan values
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Data Pesanan Berhasil Dibuat']));
    
        return $response;
    });

    $app->post('/CreateDetailPesanan', function (Request $request, Response $response) {
        $data = $request->getParsedBody();

        $id_detail_pesanan = $data["id_detail_pesanan"]; // menambah dengan kolom baru
        $id_pesanan = $data["id_pesanan"];
        $id_produk = $data["id_produk"];
        $jumlah_pesanan = $data["jumlah_pesanan"];
        $subtotal = $data["subtotal"];

        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL CreateDetailPesanan(:id_detail_pesanan, :id_pesanan, :id_produk, :jumlah_pesanan, :subtotal)');
        $query->bindParam(':id_detail_pesanan', $id_detail_pesanan, PDO::PARAM_INT);
        $query->bindParam(':id_pesanan', $id_pesanan, PDO::PARAM_INT);
        $query->bindParam(':id_produk', $id_produk, PDO::PARAM_INT);
        $query->bindParam(':jumlah_pesanan', $jumlah_pesanan, PDO::PARAM_INT);
        $query->bindParam(':subtotal', $subtotal, PDO::PARAM_INT);

        // urutan harus sesuai dengan values
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Data Detail Pesanan Berhasil Dibuat']));
    
        return $response;
    });

    // put data
    $app->put('/UpdatePelanggan/{id_pelanggan}', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody(); 
    
        $id_pelanggan = $args['id_pelanggan'];
        $nama_pelanggan = $data['nama_pelanggan'];
        $alamat = $data['alamat'];
        $no_telepon = $data['no_telepon'];
    
        $db = $this->get(PDO::class);
    
        $query = $db->prepare('CALL UpdatePelanggan(:id_pelanggan, :nama_pelanggan, :alamat, :no_telepon)');
        $query->bindParam(':id_pelanggan', $id_produk, PDO::PARAM_INT);
        $query->bindParam(':nama_pelanggan', $nama_produk, PDO::PARAM_STR);
        $query->bindParam(':alamat', $harga, PDO::PARAM_STR);
        $query->bindParam(':no_telepon', $stok, PDO::PARAM_STR);
    
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Update Pelanggan Berhasil']));
    
        return $response;
    });

    $app->put('/UpdateProduk/{id_produk}', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody(); // Ambil data yang dikirim dalam body PUT request
    
        $id_produk = $args['id_produk']; // Ambil ID produk dari parameter URL
        $nama_produk = $data['nama_produk'];
        $harga = $data['harga'];
        $stok = $data['stok'];
    
        $db = $this->get(PDO::class);
    
        $query = $db->prepare('CALL UpdateProduk(:id_produk, :nama_produk, :harga, :stok)');
        $query->bindParam(':id_produk', $id_produk, PDO::PARAM_INT);
        $query->bindParam(':nama_produk', $nama_produk, PDO::PARAM_STR);
        $query->bindParam(':harga', $harga, PDO::PARAM_INT);
        $query->bindParam(':stok', $stok, PDO::PARAM_INT);
    
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Update Produk Berhasil']));
    
        return $response;
    });

    $app->put('/UpdatePesanan/{id_pesanan}', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody(); 
    
        $id_pesanan = $args['id_pesanan'];
        $tanggal_pesanan = $data['tanggal_pesanan'];
        $id_pelanggan = $data['id_pelanggan'];
        $total_harga = $data['total_harga'];
    
        $db = $this->get(PDO::class);
    
        $query = $db->prepare('CALL UpdatePesanan(:id_pesanan, :tanggal_pesanan, :id_pelanggan, :total_harga)');
        $query->bindParam(':id_pesanan', $id_pesanan, PDO::PARAM_INT);
        $query->bindParam(':tanggal_pesanan', $tanggal_pesanan, PDO::PARAM_STR);
        $query->bindParam(':id_pelanggan', $id_pelanggan, PDO::PARAM_INT);
        $query->bindParam(':total_harga', $total_harga, PDO::PARAM_INT);
    
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Update Pesanan Berhasil']));
    
        return $response;
    });

    $app->put('/UpdateDetailPesanan/{id_detail_pesanan}', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
    
        $id_detail_pesanan = $args['id_detail_pesanan'];
        $id_pesanan = $data['id_pesanan'];
        $id_produk = $data['id_produk'];
        $jumlah_pesanan = $data['jumlah_pesanan'];
        $subtotal = $data['subtotal'];
    
        $db = $this->get(PDO::class);
    
        $query = $db->prepare('CALL UpdateDetailPesanan(:id_detail_pesanan, :id_pesanan, :id_produk, :jumlah_pesanan, :subtotal)');
        $query->bindParam(':id_detail_pesanan', $id_detail_pesanan, PDO::PARAM_INT);
        $query->bindParam(':id_pesanan', $id_pesanan, PDO::PARAM_INT);
        $query->bindParam(':id_produk', $id_produk, PDO::PARAM_INT);
        $query->bindParam(':jumlah_pesanan', $jumlah_pesanan, PDO::PARAM_INT);
        $query->bindParam(':subtotal', $subtotal, PDO::PARAM_INT);
    
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Update Produk Berhasil']));
    
        return $response;
    });

    // delete data
    $app->delete('/DeletePelanggan/{id_pelanggan}', function (Request $request, Response $response, $args) {
        $id_pelanggan = $args['id_pelanggan']; // Ambil ID pelanggan dari parameter URL
    
        $db = $this->get(PDO::class);
    
        $query = $db->prepare('CALL DeletePelanggan(:id_pelanggan)');
        $query->bindParam(':id_pelanggan', $id_pelanggan, PDO::PARAM_INT);
    
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Pelanggan Berhasil Dihapus']));
    
        return $response;
    });

    $app->delete('/DeleteProduk/{id_produk}', function (Request $request, Response $response, $args) {
        $id_produk = $args['id_produk']; // Ambil ID produk dari parameter URL
    
        $db = $this->get(PDO::class);
    
        $query = $db->prepare('CALL DeleteProduk(:id_produk)');
        $query->bindParam(':id_produk', $id_produk, PDO::PARAM_INT);
    
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Produk Berhasil Dihapus']));
    
        return $response;
    });

    $app->delete('/DeletePesanan/{id_pesanan}', function (Request $request, Response $response, $args) {
        $id_pesanan = $args['id_pesanan']; // Ambil ID pesanan dari parameter URL
    
        $db = $this->get(PDO::class);
    
        $query = $db->prepare('CALL DeletePesanan(:id_pesanan)');
        $query->bindParam(':id_pesanan', $id_pesanan, PDO::PARAM_INT);
    
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Pesanan Berhasil Dihapus']));
    
        return $response;
    });

    $app->delete('/DeleteDetailPesanan/{id_detail_pesanan}', function (Request $request, Response $response, $args) {
        $id_detail_pesanan = $args['id_detail_pesanan']; // Ambil ID detail_pesanan dari parameter URL
    
        $db = $this->get(PDO::class);
    
        $query = $db->prepare('CALL DeleteDetailPesanan(:id_detail_pesanan)');
        $query->bindParam(':id_detail_pesanan', $id_detail_pesanan, PDO::PARAM_INT);
    
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Detail Pesanan Berhasil dihapus']));
    
        return $response;
    });

};
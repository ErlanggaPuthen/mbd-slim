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
    $app->get('/pelanggan', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL GetPelanggan()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    $app->get('/produk', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL GetProduk');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    $app->get('/pesanan', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL GetPesanan');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    $app->get('/detail_pesanan', function (Request $request, Response $response) {
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
    $app->post('/create_pelanggan', function (Request $request, Response $response) {
        $data = $request->getParsedBody();

        $nama_pelanggan = $data["nama_pelanggan"]; // menambah dengan kolom baru
        $alamat = $data["alamat"];
        $no_telepon = $data["no_telepon"];

        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL CreatePelanggan(:nama_pelanggan, :alamat, :no_telepon)');
        $query->bindParam(':nama_pelanggan', $nama_pelanggan, PDO::PARAM_VARCHAR);
        $query->bindParam(':alamat', $alamat, PDO::PARAM_VARCHAR);
        $query->bindParam(':no_telepon', $no_telepon, PDO::PARAM_VARCHAR);

        // urutan harus sesuai dengan values
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Data Pelanggan Berhasil Dibuat']));
    
        return $response;
    });

    $app->post('/create_produk', function (Request $request, Response $response) {
        $data = $request->getParsedBody();

        $nama_produk = $data["nama_produk"]; // menambah dengan kolom baru
        $harga = $data["harga"];
        $stok = $data["stok"];

        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL CreateProduk(:nama_produk, :harga, :stok)');
        $query->bindParam(':nama_produk', $nama_produk, PDO::PARAM_VARCHAR);
        $query->bindParam(':harga', $harga, PDO::PARAM_DECIMAL);
        $query->bindParam(':stok', $stok, PDO::PARAM_INT);

        // urutan harus sesuai dengan values
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Data Produk Berhasil Dibuat']));
    
        return $response;
    });

    $app->post('/create_pesanan', function (Request $request, Response $response) {
        $data = $request->getParsedBody();

        $tanggal_pesanan = $data["tanggal_pesanan"]; // menambah dengan kolom baru
        $id_pelanggan = $data["id_pelanggan"];
        $total_harga = $data["total_harga"];

        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL CreatePesanan(:tanggal_pesanan, :id_pelanggan, :total_harga)');
        $query->bindParam(':tanggal_pesanan', $tanggal_pesanan, PDO::PARAM_DATE);
        $query->bindParam(':id_pelanggan', $id_pelanggan, PDO::PARAM_INT);
        $query->bindParam(':total_harga', $total_harga, PDO::PARAM_DECIMAL);

        // urutan harus sesuai dengan values
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Data Pesanan Berhasil Dibuat']));
    
        return $response;
    });

    $app->post('/create_detail_pesanan', function (Request $request, Response $response) {
        $data = $request->getParsedBody();

        $id_pesanan = $data["id_pesanan"]; // menambah dengan kolom baru
        $id_produk = $data["id_produk"];
        $jumlah_pesanan = $data["jumlah_pesanan"];
        $subtotal = $data["subtotal"];

        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL CreateDetailPesanan(:id_pesanan, :id_produk, :jumlah_pesanan, :subtotal)');
        $query->bindParam(':id_pesanan', $id_pesanan, PDO::PARAM_INT);
        $query->bindParam(':id_produk', $id_produk, PDO::PARAM_INT);
        $query->bindParam(':jumlah_pesanan', $jumlah_pesanan, PDO::PARAM_INT);
        $query->bindParam(':subtotal', $subtotal, PDO::PARAM_DECIMAL);

        // urutan harus sesuai dengan values
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Data Detail Pesanan Berhasil Dibuat']));
    
        return $response;
    });

    // put data
    $app->put('/update_produk/{id}', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody(); // Ambil data yang dikirim dalam body PUT request
    
        $id = $args['id']; // Ambil ID mobil dari parameter URL
        $merk = $data['merk'];
        $kapasitas = $data['kapasitas'];
        $harga_rental_perhari = $data['harga_rental_perhari'];
    
        $db = $this->get(PDO::class);
    
        $query = $db->prepare('CALL UpdateMobil(:id, :merk, :kapasitas, :harga_rental_perhari)');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':merk', $merk, PDO::PARAM_STR);
        $query->bindParam(':kapasitas', $kapasitas, PDO::PARAM_INT);
        $query->bindParam(':harga_rental_perhari', $harga_rental_perhari, PDO::PARAM_INT);
    
        $query->execute();
    
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Mobil berhasil diperbarui']));
    
        return $response;
    });

        return $response->withHeader("Content-Type", "application/json");
    });

    // delete data
    $app->delete('/countries/{id}', function (Request $request, Response $response, $args) {
        $currentId = $args['id'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('DELETE FROM countries WHERE id = ?');
            $query->execute([$currentId]);

            if ($query->rowCount() === 0) {
                $response = $response->withStatus(404);
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Data tidak ditemukan'
                    ]
                ));
            } else {
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'country dengan id ' . $currentId . ' dihapus dari database'
                    ]
                ));
            }
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(
                [
                    'message' => 'Database error ' . $e->getMessage()
                ]
            ));
        }

        return $response->withHeader("Content-Type", "application/json");
    });
};

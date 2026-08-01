<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../database.php";
require_once __DIR__ . "/../reservation.php";

class reservationTest extends TestCase
{
    private PDO $pdo;
    protected function setUp(): void
    {
        parent::setUp();

        $this->pdo = connect();
        $this->pdo->beginTransaction();

        $this->pdo->exec("INSERT INTO felhasznalo (id, email, pw, rendszam) VALUES (101, 'resTest1@test.com', 'test', 'AAA-123'), (102, 'resTest2@test.com', 'test', 'XXX-789'),(103, 'resTest3@test.com', 'test', 'GGG-555')");

        $this->pdo->exec("INSERT INTO foglalas (id, kezdeti_datum, veg_datum, felhasznalo_id, parkolohely_szam) VALUES (1, '2026-08-01 10:00:00', '2026-08-01 12:00:00', 101, 1), (2, '2026-08-01 14:00:00', '2026-08-01 16:00:00', 102, 2)");
    }

    protected function tearDown(): void
    {
        $this->pdo->rollBack();

        parent::tearDown();
    }

    public function testValidReservation(){
        createReservation($this->pdo,"2026-08-01 08:00:00","2026-08-01 09:00:00",103);

        $stmt = $this->pdo->query("SELECT * FROM foglalas WHERE felhasznalo_id = 103");

        $result = $stmt->fetch();

        $this->assertNotFalse($result);
        $this->assertEquals(1,$result["parkolohely_szam"]);
    }
}

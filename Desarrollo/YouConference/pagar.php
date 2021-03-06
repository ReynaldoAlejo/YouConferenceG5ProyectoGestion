<?php

if(!isset($_POST['total_pedido'], $_POST['nombre'])) {

  exit("Hubo un error");

}

use PayPal\Api\Payer; // Clases importadas, como en Java
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

require 'includes/paypal.php';

if(isset($_POST['enviar'])) {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $regalo = $_POST['regalo'];
    $total = $_POST['total_pedido'];
    $fecha = date('Y-m-d H:i:s');

    // Pedidos

    $boletos = $_POST['boletos'];
    $numeroBoletos = $boletos;
    $camisas = $_POST['pedido_extra']['camisas']['cantidad'];
    $precioCamisa = $_POST['pedido_extra']['camisas']['precio'];
    $etiquetas = $_POST['pedido_extra']['etiquetas']['cantidad'];
    $precioEtiquetas = $_POST['pedido_extra']['etiquetas']['precio'];

    include_once 'includes/funciones/funciones.php';

    $pedido = productos_json($boletos, $camisas, $etiquetas);

    // Eventos
    if(isset($_POST['registro'])) { $eventos = $_POST['registro']; }

   // $eventos = $_POST['registro'];
    $registro = eventos_json($eventos);

  }

    try {

      require_once 'includes/funciones/bd_conexion.php';
      $stmt = $conn->prepare("INSERT INTO registrados(nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"); // stmt = statement
      $stmt->bind_param("ssssssis", $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);
      $stmt->execute();
      $id_registro = $stmt->insert_id;
      $stmt->close();
      $conn->close();

    }

    catch (exception $e) {

      die('Ha ocurrido un error: ' . $e->getMessage());

    }


$envio = 0;
$subtotal = 0;
$listArt = array();
$i = 0;

foreach($numeroBoletos as $clave => $valor) { //$valor = Otro array

  if((int) $valor['cantidad'] > 0) {

    ${"articulo$i"} = new Item(); // Crear variables con un ciclo, finally

    ${"articulo$i"}->setName('Pase: ' . $clave)
             ->setCurrency('USD')
             ->setQuantity((int) $valor['cantidad'])
             ->setPrice((int) $valor['precio']);

    $subtotal += ${"articulo$i"}->getQuantity() * ${"articulo$i"}->getPrice();
    $listArt[] = ${"articulo$i"};

    $i++;

    }

  }

if($camisas > 0) {

  $articulo = new Item();

  $articulo->setName("Camisas")
           ->setCurrency('USD')
           ->setQuantity((int) $camisas)
           ->setPrice((int) $precioCamisa);

  $descuento = new Item();
  $descuento->setName("Descuento 7 %")
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice((int) -1 * ($articulo->getQuantity() * $articulo->getPrice() * 0.07));

  $subtotal += $articulo->getQuantity() * $articulo->getPrice();
  $subtotal += $descuento->getPrice();
  $listArt[] = $descuento;
  $listArt[] = $articulo;

}

if($etiquetas > 0) {

  $articulo = new Item();

  $articulo->setName("Etiquetas")
           ->setCurrency('USD')
           ->setQuantity((int) $etiquetas)
           ->setPrice((int) $precioEtiquetas);

  $subtotal += $articulo->getQuantity() * $articulo->getPrice();
  $listArt[] = $articulo;

}


$total = $subtotal + $envio;

$compra = new Payer(); // Crear comprador, el que paga
$compra->setPaymentMethod('paypal'); // M??todo de pago, saldo PayPal en este caso

$listaArticulos = new ItemList(); // Crear lista de art??culos
$listaArticulos->setItems($listArt); // Agregar los art??culos

$detalles = new Details(); // Crear detalles
$detalles->setShipping($envio) // Costo del env??o
         ->setSubtotal($subtotal); // Subtotal, solo el precio, sin env??o

$cantidad = new Amount(); // Crear el monto
$cantidad->setCurrency('USD') // Moneda
         ->setTotal($total) // Total, siempre poner aqu?? el precio m??s el env??o
         ->setDetails($detalles); // Detalles



$transaccion = new Transaction(); // Crear transacci??n
$transaccion->setAmount($cantidad) // El monto con todos sus detalles
            ->setItemList($listaArticulos) // La lista de art??culos
            ->setDescription('Pago YouConference') // Descripci??n del pago
            ->setInvoiceNumber($idRegistro); // N??mero de factura para ubicar el pedido, identificador, en este caso es el ID insertado en la BD

$redireccionar = new RedirectUrls();

$redireccionar->setReturnUrl(URL_SITIO . "/pago_finalizado.php?id_pago={$id_registro}") // URL a la que el usuario ser?? redirigido en caso de que el pago se haya hecho correctamente
              ->setCancelUrl(URL_SITIO . "/pago_finalizado.php?id_pago={$id_registro}"); // URL a la que el usuario ser?? redirigido en caso de que haya cancelado la transacci??n

$pago = new Payment(); // Crear la instancia para el pago
$pago->setIntent("sale") // La intenci??n del pago
     ->setPayer($compra) // Todos los detalles de la compra
     ->setRedirectUrls($redireccionar) // Las URLs a utilizar
     ->setTransactions(array($transaccion)); // La transacci??n, lo recibe como un array

try {

  $pago->create($apiContext); // Crear el pago, utilizando el ClienteID y el Secret, esto redirigir?? a PayPal, pero no jal?? por razones desconocidas, ya jal??

} catch(PayPal\Exception\PayPalConnectionException $pce) {

  echo "<pre>";
  print_r(json_decode($pce->getData())); // La excepci??n viene como JSON, hay que pasarlo a texto plano
  exit; // No usarlo cuando sean pagos reales, ni mostrar errores, es decir, no hacer esto en entornos de producci??n

}

$aprobado = $pago->getApprovalLink(); // Enlace de aprobaci??n

header("location: {$aprobado}"); // Ten??an que ser las comillas, hab??a puesto simples, eran dobles

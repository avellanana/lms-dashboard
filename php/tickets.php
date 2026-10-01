<?php

require "db.php";

if (isset($_POST["delete_ticket"])) {

    $ticketId = $_POST["ticket_id"];

    $stmt = $conn->prepare(
        "DELETE FROM tickets WHERE id = ?"
    );

    $stmt->bind_param("i", $ticketId);

    $stmt->execute();

    header("Location: tickets.php");
    exit;
}

if (isset($_POST["update_status"])) {

    $ticketId = $_POST["ticket_id"];
    $status = $_POST["status"];

    $stmt = $conn->prepare(
        "UPDATE tickets SET status = ? WHERE id = ?"
    );

    $stmt->bind_param("si", $status, $ticketId);

    $stmt->execute();

    header("Location: tickets.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = $_POST["title"];
    $description = $_POST["description"];

    $stmt = $conn->prepare(
    "INSERT INTO tickets (title, description, status)
     VALUES (?, ?, ?)"
     );
     
     $status = "Abierto";
     
     $stmt->bind_param("sss", $title, $description, $status);
     
     $stmt->execute();

     header("Location: tickets.php");
     exit;
}

$result = $conn->query("SELECT * FROM tickets");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>LMS Ticket System</title>
    <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet"
    >
</head>
<body>
<main class="container py-4">

<h1>Crear ticket</h1>

<form method="POST" class="mb-4">
    <input type="text" name="title" class="form-control mb-3" placeholder="Título" required>

    <textarea name="description" class="form-control mb-3" placeholder="Descripción" required></textarea>

    <button type="submit" class="btn btn-primary">Crear ticket</button>
</form>

<hr>

<h1>Tickets</h1>

<?php
while ($ticket = $result->fetch_assoc()) {
    echo "<div class='card mb-3'>";
    echo "<div class='card-body'>";

    echo "<h2 class='card-title'>" . $ticket["title"] . "</h2>";
    echo "<p class='card-text'>" . $ticket["description"] . "</p>";
    echo "<p><strong>Estado:</strong> " . $ticket["status"] . "</p>";

    echo "<form method='POST'>
            <input type='hidden' name='ticket_id' value='" . $ticket["id"] . "'>
            <select name='status'>
                <option value='Abierto'>Abierto</option>
                <option value='En revisión'>En revisión</option>
                <option value='Cerrado'>Cerrado</option>
            </select>
            <button type='submit' name='update_status' class='btn btn-secondary btn-sm'>Actualizar</button>
        </form>";

    echo "<form method='POST'>
        <input type='hidden' name='ticket_id' value='" . $ticket["id"] . "'>
        <button type='submit' name='delete_ticket' class='btn btn-outline-danger btn-sm'>Eliminar</button>
      </form>";

    echo "</div>";
    echo "</div>";
    
}
?>
</main>
</body>
</html>


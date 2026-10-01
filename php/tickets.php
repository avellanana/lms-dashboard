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

<h1>Crear ticket</h1>

<form method="POST">
    <input type="text" name="title" placeholder="Título" required>
    <br><br>

    <textarea name="description" placeholder="Descripción" required></textarea>
    <br><br>

    <button type="submit">Crear ticket</button>
</form>

<hr>

<h1>Tickets</h1>

<?php
while ($ticket = $result->fetch_assoc()) {
    echo "<h2>" . $ticket["title"] . "</h2>";
    echo "<p>" . $ticket["description"] . "</p>";
    echo "<p>Estado: " . $ticket["status"] . "</p>";

    echo "<form method='POST'>
            <input type='hidden' name='ticket_id' value='" . $ticket["id"] . "'>
            <select name='status'>
                <option value='Abierto'>Abierto</option>
                <option value='En revisión'>En revisión</option>
                <option value='Cerrado'>Cerrado</option>
            </select>
            <button type='submit' name='update_status'>Actualizar</button>
        </form>";

    echo "<form method='POST'>
        <input type='hidden' name='ticket_id' value='" . $ticket["id"] . "'>
        <button type='submit' name='delete_ticket'>Eliminar</button>
      </form>";

          echo "<hr>";
    
}
?>


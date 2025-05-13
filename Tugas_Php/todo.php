<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Atur tampilan nama dan foto berdasarkan akun
if ($username === 'admin') {
    $foto_path = "_DSC2866.jpg";
    $nama_tampil = "admin - 235314017";
} else {
    $foto_path = "Gambar2.jpg";
    $nama_tampil = $username;
}

// Ambil data to-do dari database
$todos = [];
$query = $conn->query("SELECT * FROM todos WHERE user_id = $user_id");
while ($data = $query->fetch_assoc()) {
    $todos[] = $data;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>To Do List</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: pink;
            padding: 50px;
        }

        .container {
            background-color:white;
            padding: 30px;
            border-radius: 12px;
            width: 400px;
            margin: auto;
            box-shadow: 8px 8px 8px rgba(0,0,0,0.1);
        }

        .profile {
            text-align: center;
            margin-bottom: 40px;
        }

        .profile img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .profile h3 {
            margin: 0;
            font-size: 18px;
        }

        form {
            text-align: center;
            margin-bottom: 50px;
        }

        input[type="text"] {
            padding: 7px;
            width: 50%;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px 14px;
            background-color: pink;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }

        .todo-list {
            margin-top: 20px;
        }

        .todo-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }

        .todo-item.completed span {
            text-decoration: line-through;
            color: #888;
        }

        .actions a {
            margin-left: 10px;
            text-decoration: none;
            font-size: 14px;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .actions .btn {
            background-color: pink;
            color: #000;
        }

        .actions .hapus {
            background-color: pink;
            color: #000;
        }

        .logout {
            text-align: center;
            margin-top: 30px;
        }

        .logout a {
            color: black;
            text-decoration: none;
        }

        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="profile">
        <img src="<?php echo $foto_path; ?>" alt="Foto Profil">
        <h3><?php echo htmlspecialchars($nama_tampil); ?></h3>
    </div>

    <form action="add.php" method="POST">
        <input type="text" name="task" placeholder="To do list" required>
        <input type="submit" value="Tambah">
    </form>

    <div class="todo-list">
        <?php foreach ($todos as $todo): ?>
            <div class="todo-item <?= $todo['is_done'] ? 'completed' : '' ?>">
                <span><?= htmlspecialchars($todo['task']) ?></span>
                <div class="actions">
                    <a href="done.php?id=<?= $todo['id'] ?>" class="btn">
                        <?= $todo['is_done'] ? 'Batal' : 'Selesai' ?>
                    </a>
                    <a href="delete.php?id=<?= $todo['id'] ?>" class="btn hapus"
                       onclick="return confirm('Apakah kamu yakin ingin menghapus tugas ini?')">Hapus</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>

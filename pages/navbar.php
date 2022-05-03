<header>
    <div>
        <a href="./homepage.php">Buongiorno <?= ucfirst($_SESSION['nome']); ?></a>
    </div>

    <button onclick="closeSession()">
        <img src="../immagini/logout.png" alt="logout">
    </button>
</header>
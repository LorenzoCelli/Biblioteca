<form action="script.php" method="post">
    <div id="new_menu_img" class="book_image"></div>
    <h1>Libro XXX</h1>
    <input type="number" placeholder="ISBN" name="isbn">
    <input type="text" placeholder="Titolo" name="titolo" required>
    <input type="text" placeholder="Autore" name="autore" required>
    <textarea rows="4" cols="50" placeholder="Descrizione" name="descr" ></textarea>
    <input type="text" placeholder="Url immagine" name="img_url" required>
    <h2>Dove si trova?</h2>
    Libreria:
    <select name="nome_libreria" onchange="listalibrerie()">
        <option></option>
        <?php
        $sql = "SELECT * FROM libreria WHERE id_utente = '$id_utente'";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
            echo "
              <option value='".$row['nome']."'>".$row['nome']."</option>
              ";
        }
        ?>
    </select>
    <script>
        var libreria = {};
        <?php
        $sql = "SELECT * FROM libreria WHERE id_utente = '$id_utente'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            echo "
            libreria['".$row['nome']."'] = ".$row['n_scaffali'].";
            ";
        }
        ?>
    </script>
    Scaffale:
    <select name="scaffale">
        <option></option>
    </select>
    <input type="submit" value="aggiungi">
    <input type="reset" value="annulla" onclick="slide_new_menu()">
</form>
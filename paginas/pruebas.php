<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data'];

    foreach ($data as $fila) {
        // $fila es un array con los 12 valores de esa fila
        $col1 = $fila[0];
        $col2 = $fila[1];
        $col3 = $fila[2];
        $col4 = $fila[3];
        $col5 = $fila[4];
        $col6 = $fila[5];
        $col7 = $fila[6];
        $col8 = $fila[7];
        $col9 = $fila[8];
        $col10 = $fila[9];
        $col11 = $fila[10];
        $col12 = $fila[11];

        $sql = "INSERT INTO mi_tabla (col1, col2, ..., col12) 
                VALUES (?, ?, ..., ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssss", $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10, $col11, $col12);
        $stmt->execute();
    }
}
?>

<style>
  table {
    border-collapse: collapse; /* elimina espacio entre celdas */
  }

  td {
    border: 1px solid #000;
    padding: 0;
    margin: 0;
  }

  input, textarea {
    width: 100%;
    height: 100%;
    border: none;
    box-sizing: border-box;
    padding: 0;
    margin: 0;
    resize: none;   /* textarea no redimensionable */
    font-family: inherit;
    font-size: inherit;
  }
</style>

<form method="post" action="guardar.php">
  <table  border=1>
    <tr>
                        <th>Capítulo</th>
                        <th>Escena</th>
                        <th>Plano</th>
                        <th>Toma</th>
                        <th>Retoma</th>
                        <th>Clip Cam 1</th>
                        <th>Time Cam 1</th>
                        <th>Clip Cam 2</th>
                        <th>Time Cam 2</th>
                        <th>Clip Cam 3</th>
                        <th>Time Cam 3</th>
                        <th>Observaciones</th>                        
                    </tr>
    <!-- Definición de tamaños de columnas -->
    <colgroup>
      <!-- Columnas 1 a 11 más estrechas -->
      <?php for ($j = 0; $j < 11; $j++): ?>
        <col style="width: 80px;">
      <?php endfor; ?>

      <!-- Columna 12 más ancha -->
      <col style="width: 300px;">
    </colgroup>

    <?php for ($i = 0; $i < 19; $i++): ?>
      <tr>
        <?php for ($j = 0; $j < 12; $j++): ?>
          <td>
            <?php if ($j == 11): ?>
              <textarea name="data[<?= $i ?>][<?= $j ?>]"></textarea>
            <?php else: ?>
              <input type="text" name="data[<?= $i ?>][<?= $j ?>]" />
            <?php endif; ?>
          </td>
        <?php endfor; ?>
      </tr>
    <?php endfor; ?>
  </table>

  <br>
  <button type="submit">Guardar</button>
</form>

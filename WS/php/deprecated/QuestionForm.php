<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <script src="../js/jquery-3.4.1.min.js"> </script>
  <script src="../js/ValidateFieldsQuestionJQ.js"></script>
</head>

<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
    <div>
  <form id="galderenF" name="galderenF" action="AddQuestion.php" onsubmit="return ValidateFieldsQuestionJQ()" method="post">

        <label for="uposta">Zure posta (*):</label>
          <input type="text" name="uposta" id="uposta"><br>
        <label for="tgaldera">Galdera (*):</label>
          <textarea name="tgaldera" id="tgaldera"></textarea><br>

        <label for="ezuzena">Erantzun zuzena (*):</label>
          <input type="text" name="ezuzena" id="ezuzena" ><br>
        <label for="eokerra1">Erantzun okerra 1 (*):</label>
          <input type="text" name="eokerra1" id="eokerra1" ><br>
        <label for="eokerra2">Erantzun okerra 2 (*):</label>
          <input type="text" name="eokerra2" id="eokerra2" ><br>
        <label for="eokerra3">Erantzun okerra 3 (*):</label>
          <input type="text" name="eokerra3" id="eokerra3" ><br>

        <label for="zaitasun">Zailtasuna (*):</label>
          <input type="radio" name="zailtasun" id="zHandia" value="3"> <label for="zHandia">Handia</label>
          <input type="radio" name="zailtasun" id="zErtaina" value="2"> <label for="zErtaina">Ertaina</label>
          <input type="radio" name="zailtasun" id="zTxikia" value="1"> <label for="zTxikia">Txikia</label> <br>

        <label for="gArloa">Galderaren gai-arloa (*):</label>
          <input type="text" name="gArloa" id="gArloa"><br>

          <input type="submit" name="submitbutton" id="submitbutton" value="Bidali">
        </form>
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
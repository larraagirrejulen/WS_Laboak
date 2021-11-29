<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <script src="../js/ShowImageInForm.js"></script>
</head>

<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1"> <!-- section ez da existitzen HTML4 an -->
    <div>
  <form id="galderenF" name="galderenF" action="AddQuestion.php">

        <label for="uposta">Zure posta (*):</label>
          <input type="text" name="uposta" id="uposta" pattern="^([A-Za-z]+\d{3}@ikasle\.ehu\.(eus|es)|[A-Za-z]+\.?[A-Za-z]*@ehu\.(eus|es)){1}$" required><br>
        <label for="tgaldera">Galdera (*):</label>
          <textarea name="tgaldera" id="tgaldera" minlength="10" required></textarea><br>

        <label for="ezuzena">Erantzun zuzena (*):</label>
          <input type="text" name="ezuzena" id="ezuzena" required><br>
        <label for="eokerra1">Erantzun okerra 1 (*):</label>
          <input type="text" name="eokerra1" id="eokerra1" required><br>
        <label for="eokerra2">Erantzun okerra 2 (*):</label>
          <input type="text" name="eokerra2" id="eokerra2" required><br>
        <label for="eokerra3">Erantzun okerra 3 (*):</label>
          <input type="text" name="eokerra3" id="eokerra3" required><br>

        <label for="zaitasun">Zailtasuna (*):</label>
          <input type="radio" name="zailtasun" id="zHandia" value="3" required> <label for="zHandia">Handia</label>
          <input type="radio" name="zailtasun" id="zErtaina" value="2" > <label for="zErtaina">Ertaina</label>
          <input type="radio" name="zailtasun" id="zTxikia" value="1" > <label for="zTxikia">Txikia</label> <br>

        <label for="gArloa">Galderaren gai-arloa (*):</label>
          <input type="text" name="gArloa" id="gArloa" required><br>

        <label for="gIrudia"> Galderarekin zerikusirik duen irudia:</label><br>
          <input type="file" id="gIrudia" ><br>
          
        <input type="submit" name="submitbutton" id="submitbutton" value="Bidali">
        <input type="reset" name="hustu" id="hustu" value="Hustu"><br>

        <!-- <img src="" id="irudia" width=200px> -->
        </form>
        

    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
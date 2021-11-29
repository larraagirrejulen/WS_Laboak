<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <script src='../js/jquery-3.4.1.min.js'> </script>
  <script src='../js/ValidateFieldsQuestionJQ.js'></script>
  <link rel="stylesheet" type="text/css" href="../styles/BoxTypes.css">
  <script src='../js/ShowImageInForm.js'></script>
  <style type='text/css'>
    #galderenF label, input, textarea{
      margin-bottom: 2px;
      margin-top: 2px;
      margin-right: 4px;
      vertical-align: middle;
    }
    #galderenF{
      margin-left: 50px;
      text-align: left;
    }
    #galderenF h2{
      margin-bottom: 4px;
    }

  </style>
</head>

<body>
  <?php include '../php/Menus.php' ?>
  <section class='main' id='s1'> <!-- section ez da existitzen HTML4 an -->
  <?php
    if(!$logeatuta){
      echo("<div class='errorBox'><p>Ezin duzu funtzionalitate hau atzitu logeatuta ez bazaude.</p><p> Logeatu eta saiatu berriro.</p></div> ");
    }else if($session_mota == "ikasle" || $session_mota == "irakasle"){
      echo "<div>
        <form id='galderenF' enctype='multipart/form-data' method='POST' name='galderenF' action='AddQuestionWithImage.php' onsubmit='return ValidateFieldsQuestionJQ()'>

          <h2>Formularioa</h2>

          <label for='uposta'>Zure posta <font color='red'>(*)</font></label>
          <input type='text' name='uposta' id='uposta' value='$session_posta' readonly><br>

          <label for='tgaldera'>Galdera <font color='red'>(*)</font></label>
            <textarea name='tgaldera' id='tgaldera'></textarea><br>

          <label for='ezuzena'>Erantzun zuzena <font color='red'>(*)</font></label>
            <input type='text' name='ezuzena' id='ezuzena' ><br>
          <label for='eokerra1'>Erantzun okerra 1 <font color='red'>(*)</font></label>
            <input type='text' name='eokerra1' id='eokerra1' ><br>
          <label for='eokerra2'>Erantzun okerra 2 <font color='red'>(*)</font></label>
            <input type='text' name='eokerra2' id='eokerra2' ><br>
          <label for='eokerra3'>Erantzun okerra 3 <font color='red'>(*)</font></label>
            <input type='text' name='eokerra3' id='eokerra3' ><br>

          <label for='zaitasun'>Zailtasuna <font color='red'>(*)</font></label>
            <input type='radio' name='zailtasun' id='zHandia' value='3'> <label for='zHandia'>Handia</label>
            <input type='radio' name='zailtasun' id='zErtaina' value='2'> <label for='zErtaina'>Ertaina</label>
            <input type='radio' name='zailtasun' id='zTxikia' value='1'> <label for='zTxikia'>Txikia</label> <br>

          <label for='gArloa'>Galderaren gai-arloa <font color='red'>(*)</font></label>
            <input type='text' name='gArloa' id='gArloa'><br>

          <label for='gIrudia'> Galderarekin zerikusirik duen irudia:</label><br>
            <input name='fileName' type='file' id='gIrudia'/><br>
            <!-- <input type='hidden' name='MAX_FILE_SIZE' value='30000' /> -->

          <input type='submit' name='submitbutton' id='submitbutton' value='Bidali'>
          <input type='reset' name='hustu' id='hustu' value='Hustu'><br>

        </form>
      </div>";
    }else{
      echo("<div class='errorBox'><p>Ezin duzu funtzionalitate hau atzitu duzun rolarekin.</p>/div> ");
    }
  ?>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>

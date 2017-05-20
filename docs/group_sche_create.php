<!DOCTYPE html>
<html>
  <head>
    <title>UniScheduler</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link rel="stylesheet" type="text/css" href="./css/group_sche_create.css" />
  </head>

  <body>
    <?php include ( "./headerMenu.php" ); ?>
    <form>
      <div class="textbox">
        <label for="group_name">Group name: </label>
        <input type="text" id="group_name" placeholder="Enter group name">
      </div>
      <div class='container'>
        <div class="friends-select">
          <select name='select' size='100' multiple>
            <option value="1">Jason</option>
            <option value="2">Eunchul</option>
            <option value="3">Dongju</option>
          </select>
        </div>
        <input type="submit" id="btn-submit" value="Submit">
        <div class="selected">
          <select size='100'>
            <option value='1'>Should be implemented...</option>
          </select>
        </div>
      </div>
          </form>
  </body>
</html>

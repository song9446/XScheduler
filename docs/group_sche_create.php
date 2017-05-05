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
      <div class="friends-select">
        <select name='select' size='5' multiple>
          <option value="1">Jason</option>
          <option value="2">Eunchul</option>
          <option value="3">Dongju</option>
        </select>
        <div id="selected"> Should be implemented...
        </div>
      </div>
      <input type="submit" id="btn-submit" value="Submit">
    </form>
  </body>
</html>

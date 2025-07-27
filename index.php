<!DOCTYPE html>
<html>
<head>
  <title>Robot Arm Control Panel</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f3f3f3;
      text-align: center;
    }
    .container {
      background: white;
      padding: 20px;
      width: 80%;
      margin: auto;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
      border-radius: 10px;
    }
    h2 { margin-bottom: 20px; }
    .slider-row {
      margin: 10px 0;
    }
    input[type=range] {
      width: 300px;
      accent-color: mediumorchid;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 10px;
    }
    button {
      margin: 10px 5px;
      padding: 10px 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Robot Arm Control Panel</h2>
    <form id="controlForm">
      <?php
        for ($i = 1; $i <= 6; $i++) {
          echo "<div class='slider-row'>
            Motor $i: 
            <input type='range' min='0' max='180' value='90' id='motor$i' name='motor$i' oninput='updateLabel($i)'>
            <span id='label$i'>90</span>
          </div>";
        }
      ?>
      <button type="button" onclick="resetSliders()">Reset</button>
      <button type="button" onclick="savePose()">Save Pose</button>
      <button type="button" onclick="runPose()">Run</button>
    </form>

    <div id="poseTable"><?php include 'get_run_pose.php'; ?></div>
  </div>

  <script>
    function updateLabel(i) {
      document.getElementById("label" + i).innerText = document.getElementById("motor" + i).value;
    }

    function resetSliders() {
      for (let i = 1; i <= 6; i++) {
        document.getElementById("motor" + i).value = 90;
        updateLabel(i);
      }
    }

    function savePose() {
      const form = document.getElementById('controlForm');
      const data = new FormData(form);

      fetch('save_pose.php', {
        method: 'POST',
        body: data
      }).then(response => response.text())
        .then(data => {
          document.getElementById("poseTable").innerHTML = data;
        });
    }

    function runPose() {
      fetch('get_run_pose.php')
        .then(response => response.text())
        .then(data => {
          document.getElementById("poseTable").innerHTML = data;
        });
    }

    function loadPose(id) {
      fetch('load_pose.php?id=' + id)
        .then(response => response.json())
        .then(data => {
          for (let i = 1; i <= 6; i++) {
            document.getElementById('motor' + i).value = data['motor' + i];
            updateLabel(i);
          }
        });
    }

    function removePose(id) {
      fetch('remove_pose.php?id=' + id)
        .then(response => response.text())
        .then(data => {
          document.getElementById("poseTable").innerHTML = data;
        });
    }
  </script>
</body>
</html>

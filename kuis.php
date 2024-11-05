<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
    <title>Modul 1</title>
    <style>
      body {
        background-color: #092635;
        margin: 0;
        font-family: "Montserrat", sans-serif;
        color: #000;
      }

      /* Header styles */
      .header {
        display: flex;
        align-items: center;
        padding: 10px;
        background-color: #092635;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      }

      .header a {
        text-decoration: none;
        color: white;
        font-size: 24px;
      }

      /* Question section styles */
      .question-section {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 60vh;
        background-color: #092635;
        padding: 20px;
      }

      .question-box {
        background-color: white;
        padding: 40px;
        width: 80%;
        max-width: 600px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      .question-box h3 {
        color: #333;
      }

      .question-option {
        margin-top: 20px;
        margin-bottom: 20px;
      }

      .question-option input {
        margin-right: 10px;
      }

      .submit-button {
        text-align: right;
      }

      .submit-button button {
        padding: 7px 40px;
        font-size: 14px;
        background-color: #2a3a5b;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }

      footer {
        background-color: #092635;
        color: white;
        padding: 20px;
      }

      .social-icons a img {
        width: 30px;
        margin-right: 10px;
      }
    </style>
  </head>
  <body>
    <!-- Header -->
    <div class="header">
      <a href="modul-kuis.php">Modul 1</a>
    </div>

    <!-- Question Section -->
    <div class="question-section">
      <div class="question-box">
        <h3>Pertanyaan 1</h3>
        <div class="question-option">
          <input type="radio" id="answer1" name="answer" />
          <label for="answer1">Pilihan Jawaban 1</label>
        </div>
        <div class="question-option">
          <input type="radio" id="answer2" name="answer" />
          <label for="answer2">Pilihan Jawaban 2</label>
        </div>
        <div class="question-option">
          <input type="radio" id="answer3" name="answer" />
          <label for="answer3">Pilihan Jawaban 3</label>
        </div>
        <div class="question-option">
          <input type="radio" id="answer4" name="answer" />
          <label for="answer4">Pilihan Jawaban 4</label>
        </div>
        <div class="submit-button">
          <button
            class="btn btn-primary"
            onclick="window.location.href='skor.php'"
          >
            Submit
          </button>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

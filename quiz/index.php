<?php
session_start();

// Question data (33 total, 30 new + 3 original, all more challenging)
$questions = [
    ['question' => 'What is the capital of France?', 'options' => ['London', 'Berlin', 'Paris', 'Madrid'], 'answer' => 'Paris'], // Kept for simplicity
    ['question' => 'Which planet has the shortest day?', 'options' => ['Venus', 'Mars', 'Jupiter', 'Saturn'], 'answer' => 'Jupiter'],
    ['question' => 'What is the value of π to 4 decimal places?', 'options' => ['3.1415', '3.1416', '3.1417', '3.1418'], 'answer' => '3.1416'],
    ['question' => 'What gas, discovered on the sun before Earth, is the second most abundant element in the universe?', 'options' => ['Hydrogen', 'Helium', 'Oxygen', 'Nitrogen'], 'answer' => 'Helium'],
    ['question' => 'Which mathematician formulated the theory of general relativity?', 'options' => ['Isaac Newton', 'Carl Gauss', 'Albert Einstein', 'Leonhard Euler'], 'answer' => 'Albert Einstein'],
    ['question' => 'What is the smallest prime number greater than 100?', 'options' => ['101', '103', '107', '109'], 'answer' => '101'],
    ['question' => 'Which element has the highest melting point?', 'options' => ['Iron', 'Tungsten', 'Platinum', 'Titanium'], 'answer' => 'Tungsten'],
    ['question' => 'What is the name of the longest river in South America?', 'options' => ['Nile', 'Amazon', 'Yangtze', 'Paraná'], 'answer' => 'Amazon'],
    ['question' => 'Which philosopher wrote "Thus Spoke Zarathustra"?', 'options' => ['Socrates', 'Plato', 'Nietzsche', 'Kant'], 'answer' => 'Nietzsche'],
    ['question' => 'What is the time complexity of binary search?', 'options' => ['O(n)', 'O(log n)', 'O(n²)', 'O(1)'], 'answer' => 'O(log n)'],
    ['question' => 'Which particle is responsible for mediating the strong nuclear force?', 'options' => ['Photon', 'Gluon', 'W Boson', 'Neutrino'], 'answer' => 'Gluon'],
    ['question' => 'What is the capital of Bhutan?', 'options' => ['Thimphu', 'Kathmandu', 'Dhaka', 'Colombo'], 'answer' => 'Thimphu'],
    ['question' => 'Which acid is the primary component of vinegar?', 'options' => ['Sulfuric', 'Hydrochloric', 'Acetic', 'Nitric'], 'answer' => 'Acetic'],
    ['question' => 'What is the largest organ in the human body?', 'options' => ['Liver', 'Skin', 'Brain', 'Lungs'], 'answer' => 'Skin'],
    ['question' => 'Which gas has the highest percentage in Earth’s atmosphere?', 'options' => ['Oxygen', 'Nitrogen', 'Carbon Dioxide', 'Argon'], 'answer' => 'Nitrogen'],
    ['question' => 'What is the square root of 729?', 'options' => ['25', '27', '29', '31'], 'answer' => '27'],
    ['question' => 'Which war was ended by the Treaty of Versailles?', 'options' => ['World War I', 'World War II', 'Napoleonic Wars', 'American Civil War'], 'answer' => 'World War I'],
    ['question' => 'What is the chemical symbol for Gold?', 'options' => ['Ag', 'Au', 'Pt', 'Hg'], 'answer' => 'Au'],
    ['question' => 'Which planet has the most moons?', 'options' => ['Jupiter', 'Saturn', 'Uranus', 'Neptune'], 'answer' => 'Saturn'],
    ['question' => 'What is the primary source of energy for Earth’s climate system?', 'options' => ['Geothermal', 'Solar', 'Wind', 'Tidal'], 'answer' => 'Solar'],
    ['question' => 'Which language has the most native speakers worldwide?', 'options' => ['English', 'Spanish', 'Mandarin', 'Hindi'], 'answer' => 'Mandarin'],
    ['question' => 'What is the boiling point of water in Kelvin?', 'options' => ['273', '373', '100', '310'], 'answer' => '373'],
    ['question' => 'Which scientist discovered penicillin?', 'options' => ['Louis Pasteur', 'Alexander Fleming', 'Marie Curie', 'Gregor Mendel'], 'answer' => 'Alexander Fleming'],
    ['question' => 'What is the largest desert in the world by area?', 'options' => ['Sahara', 'Gobi', 'Antarctic', 'Arabian'], 'answer' => 'Antarctic'],
    ['question' => 'Which element has the atomic number 92?', 'options' => ['Thorium', 'Uranium', 'Plutonium', 'Neptunium'], 'answer' => 'Uranium'],
    ['question' => 'What is the derivative of sin(x)?', 'options' => ['cos(x)', '-sin(x)', 'tan(x)', 'sec(x)'], 'answer' => 'cos(x)'],
    ['question' => 'Which country has the most volcanoes?', 'options' => ['Japan', 'Indonesia', 'United States', 'Italy'], 'answer' => 'Indonesia'],
    ['question' => 'What is the shortest war in history?', 'options' => ['38 minutes', '2 hours', '1 day', '3 days'], 'answer' => '38 minutes'],
    ['question' => 'Which mathematician proved Fermat’s Last Theorem?', 'options' => ['Andrew Wiles', 'Terence Tao', 'John Conway', 'Paul Erdős'], 'answer' => 'Andrew Wiles'],
    ['question' => 'What is the primary ingredient in guacamole?', 'options' => ['Tomato', 'Avocado', 'Onion', 'Lime'], 'answer' => 'Avocado'],
    ['question' => 'Which organelle is known as the powerhouse of the cell?', 'options' => ['Nucleus', 'Golgi Apparatus', 'Mitochondria', 'Ribosome'], 'answer' => 'Mitochondria'],
    ['question' => 'What is the speed of light in a vacuum (in m/s)?', 'options' => ['3 × 10⁶', '3 × 10⁷', '3 × 10⁸', '3 × 10⁹'], 'answer' => '3 × 10⁸'],
    ['question' => 'Which composer wrote the "Moonlight Sonata"?', 'options' => ['Mozart', 'Beethoven', 'Bach', 'Chopin'], 'answer' => 'Beethoven'],
];

// Initialize session variables (5 random questions)
if (!isset($_SESSION['questions'])) {
    shuffle($questions);
    $_SESSION['questions'] = array_slice($questions, 0, 5); // Pick 5 random questions
}

// Process quiz submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quiz'])) {
    $score = 0;
    $total = count($_SESSION['questions']);
    foreach ($_SESSION['questions'] as $index => $q) {
        $user_answer = $_POST['q' . $index] ?? '';
        if ($user_answer === $q['answer']) {
            $score++;
        }
    }
    $_SESSION['score'] = $score;
    $_SESSION['total'] = $total;
    $_SESSION['show_results'] = true;
}

// Reset for new quiz
if (isset($_POST['reset'])) {
    unset($_SESSION['questions'], $_SESSION['score'], $_SESSION['show_results']);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['show_results'])): ?>
            <!-- Results Section -->
            <h1>Your Results</h1>
            <p>You scored <?php echo $_SESSION['score']; ?> out of <?php echo $_SESSION['total']; ?>!</p>
            <form method="POST">
                <button type="submit" name="reset" class="btn">Try Again</button>
            </form>
        <?php else: ?>
            <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
                <!-- Welcome Section -->
                <h1>Welcome to the Quiz!</h1>
                <p>Test your knowledge with our challenging quiz. Ready to start?</p>
                <form method="POST">
                    <button type="submit" name="start" class="btn">Start Quiz</button>
                </form>
            <?php else: ?>
                <!-- Quiz Section -->
                <h1>Quiz Time!</h1>
                <form method="POST">
                    <?php foreach ($_SESSION['questions'] as $index => $q): ?>
                        <div class="question">
                            <p><?php echo ($index + 1) . '. ' . $q['question']; ?></p>
                            <?php foreach ($q['options'] as $option): ?>
                                <label>
                                    <input type="radio" name="q<?php echo $index; ?>" value="<?php echo $option; ?>" required>
                                    <?php echo $option; ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                    <button type="submit" name="submit_quiz" class="btn">Submit Quiz</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
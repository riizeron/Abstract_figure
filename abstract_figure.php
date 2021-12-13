<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta charset="utf-8">
    <title> Figures! </title>
</head>

<body>
    <?php
    final class Coord2D
    {
        private $X;
        private $Y;

        public function __construct($x, $y)
        {
            $this->X = $x;
            $this->Y = $y;
        }

        public function getX()
        {
            return $this->X;
        }

        public function getY()
        {
            return $this->Y;
        }

        public function __toString()
        {
            return "[$this->X, $this->Y]";
        }
    }

    abstract class Figure
    {
        protected $perimetr;
        protected $type;
        protected $square;
        protected $coords;

        public function __construct($coords)
        {
            $this->setCoords($coords);
        }

        public function setCoords($coords)
        {
            $this->square = null;
            $this->perimetr = null;
            $this->coords = $coords;
        }

        public function getSquare()
        {
            if ($this->square == null) {
                $this->calcSquare();
            }
            return $this->square;
        }

        public function getPerimetr()
        {
            if ($this->perimetr == null) {
                $this->calcPerimetr();
            }
            return $this->perimetr;
        }

        private function coordsToString()
        {
            $str = "";
            foreach ($this->coords as $value) {
                $str = "$str $value";
            }
            return $str;
        }

        public function __toString()
        {
            $str = $this->coordsToString();
            $square = $this->getSquare();
            $perimetr = $this->getPerimetr();
            $type = get_class($this);
            return "$type: coords: $str; perimetr: $perimetr; square: $square";
        }

        protected abstract function calcSquare();

        protected abstract function calcPerimetr();
    }

    class Triangle extends Figure
    {

        protected function calcSquare()
        {
            $this->square = 0.5 * abs(($this->coords[1]->getX() - $this->coords[0]->getX())
                * ($this->coords[2]->getY() - $this->coords[0]->getY()) - ($this->coords[2]->getX() - $this->coords[0]->getX())
                * ($this->coords[1]->getY() - $this->coords[0]->getY())
            );
        }

        protected function calcPerimetr()
        {
            $this->perimetr = 0;
        }
    }

    class Rectangle extends Figure
    {
        protected function calcSquare()
        {
            $this->square = abs(($this->coords[0]->getX() - $this->coords[1]->getX()) * ($this->coords[1]->getY() - $this->coords[0]->getY()));
        }

        protected function calcPerimetr()
        {
            $this->perimetr = 2 * (abs($this->coords[0]->getX() - $this->coords[1]->getX()) + abs($this->coords[1]->getY() - $this->coords[0]->getY()));
        }
    }
    ?>

    <form action="abstract_figure.php" method="get">
        Select figure:
        <p><input type="radio" id="vyb1" name="figureType" value="tri"> Triangle <br>
            <input type="radio" id="vyb2" name="figureType" value="rec"> Rectangle
        </p>
        <input type="submit" value="Ok">
    </form>

    <?php
    $rectag = new Rectangle(array());
    $triag = new Triangle(array());
    if (isset($_GET["figureType"])) {
        $figuretype = $_GET["figureType"];
        if ($figuretype == "tri") {
            echo
            '<form action = "abstract_figure.php" method = "get"> 
                    <input  hidden = "true" name = "figureType" value = ' . $_GET["figureType"] . '>
                    <p>';
            if (isset($_GET["x1"])) {
                echo '
                        X1: <input type = "number" required value = ' . $_GET["x1"] . ' name = "x1">  
                        Y1: <input type = "number" required value = ' . $_GET["y1"] . ' name = "y1"><br>
                        X2: <input type = "number" required value = ' . $_GET["x2"] . ' id = "x2" name = "x2">  
                        Y2: <input type = "number" required value = ' . $_GET["y2"] . ' name = "y2"><br>
                        X3: <input type = "number" required value = ' . $_GET["x3"] . ' id = "x3" name = "x3">  
                        Y3: <input type = "number" required value = ' . $_GET["y3"] . ' name = "y3"><br>
                        ';
            } else {
                echo '
                        X1: <input type = "number" required name = "x1">  
                        Y1: <input type = "number" required name = "y1"><br>
                        X2: <input type = "number" required id = "x2" name = "x2">  
                        Y2: <input type = "number" required name = "y2"><br>
                        X3: <input type = "number" required id = "x3" name = "x3">  
                        Y3: <input type = "number" required name = "y3"><br>
                        ';
            }
            echo '
                    </p>
                    <input type = "submit" value = "calc">
                </form>';
        } else if ($figuretype == "rec") {
            echo '
                <form action = "abstract_figure.php" method = "get">
                    <input  hidden = "true" name = "figureType" value = "rec">
                    <p>';
            if (isset($_GET["x1"])) {
                echo '
                        X1: <input type = "number" required value = ' . $_GET["x1"] . ' name = "x1">  
                        Y1: <input type = "number" required value = ' . $_GET["y1"] . ' name = "y1"><br>
                        X2: <input type = "number" required value = ' . $_GET["x2"] . ' id = "x2" name = "x2">  
                        Y2: <input type = "number" required value = ' . $_GET["y2"] . ' name = "y2"><br>
                        ';
            } else {
                echo '
                        X1: <input type = "number" required name = "x1">  
                        Y1: <input type = "number" required name = "y1"><br>
                        X2: <input type = "number" required id = "x2" name = "x2">  
                        Y2: <input type = "number" required name = "y2"><br>
                        ';
            }
            echo '
                    </p>
                    <input type = "submit" value = "calc">
                </form>';
        }
    }
    if (isset($_GET["x1"]) && isset($_GET["y1"]) && isset($_GET["x2"])
        && isset($_GET["y2"]) && !isset($_GET["x3"]) && !isset($_GET["y3"])
    ) {
        $coord1 = new Coord2D($_GET["x1"], $_GET["y1"]);
        $coord2 = new Coord2D($_GET["x2"], $_GET["y2"]);
        $coords = array($coord1, $coord2);
        $rectag->setCoords($coords);
        echo "<h3>Answer: </h3><p id = 'output2'> $rectag </p>";
    } else if (isset($_GET["x1"]) && isset($_GET["y1"]) && isset($_GET["x2"])
        && isset($_GET["y2"]) && isset($_GET["x3"]) && isset($_GET["y3"])
    ) {
        $coord1 = new Coord2D($_GET["x1"], $_GET["y1"]);
        $coord2 = new Coord2D($_GET["x2"], $_GET["y2"]);
        $coord3 = new Coord2D($_GET["x3"], $_GET["y3"]);
        $coords = array($coord1, $coord2, $coord3);
        $triag->setCoords($coords);
        echo "<h3>Answer: </h3><p id='output1'> $triag </p>";
    }
    ?>
</body>

</html>
<script>
    jQuery(document).ready(function() {
        console.log('Оба!');
        if ($('#x2').length && $('#x3').length) {
            $('#vyb1').prop('checked', true);
            console.log('Оба!3');
        } else if ($('#x2').length) {
            $('#vyb2').prop('checked', true);
            console.log('Оба!2');
        }
        if ($('#output1').length) {
            $('#vyb1').prop('checked', true);
        }
        if ($('#output2').length) {
            $('#vyb2').prop('checked', true);
        }
    });
</script>
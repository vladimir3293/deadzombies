<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>

<p>Начинаем считать:</p>

<script>

    function Calculator() {
        this.vartest = 'sdf';

        this.test = function () {
            console.log('sf');
        };

        function fsd() {
            console.log('sf');
        };

        this.methods = {
            '+': function (a, b) {
                return a + b;
            }
        }
    }
    var test;
    var  calc  =  new Calculator();
    test = calc.vartest;
    console.log(calc, calc.test());

</script>

<p>Кролики посчитаны!</p>

</body>

</html>
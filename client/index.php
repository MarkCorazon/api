<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Api Visualization</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">
</head>
<body>
    <h1 class="display-1 text-center">Api Visualization</h1>
    <div class="container col-11">
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-12 mt-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Alcohol Consumption</h5>
                        <h6 class="card-subtitle mb-2 text-muted">(Liters of pure alcohol)</h6>
                        <div id="alcoholVisualizer" style="width: 100%; height: 300px;"></div>
                        <p class="card-text">Hover over a country to reaveal the average amount of liters that people in the country drank in 2015</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 mt-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Deaths</h5>
                        <h6 class="card-subtitle mb-2 text-muted">(per 1000 residents)</h6>
                        <div id="deathsVisualizer" style="width: 100%; height: 300px;"></div>
                        <p class="card-text">Hover over a country to reaveal the deaths per 1000 residents in 2015</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 mt-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Happiness</h5>
                        <h6 class="card-subtitle mb-2 text-muted">(Score on scale of 1 to 10)</h6>
                        <div id="happinessVisualizer" style="width: 100%; height: 300px;"></div>
                        <p class="card-text">Hover over a country to reaveal the average score of how happy a person in a country is and the world rank of happiness in 2015</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-5" id="countriesInDept"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="js/visual.js" charset="utf-8"></script>
</body>
</html>

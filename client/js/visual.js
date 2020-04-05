function requestAllTableData(table, type) {
    var resp;
    $.ajax({
        url: "http://localhost/skoel/api/?type="+ type +"&set=" + table,
        method: 'GET',
        async: false,
        error: function(response) {
            alert(response);
        },
        success: function(response) {
            if(type == 'xml') {
                $(response).find('country').each(function(){
                    $(this).each(function(){
                        var name = $(this).attr("name");
                        console.log(name);
                    });
                });
            }
            validateRequestedData(response, table, type);
            resp = response;
        }
    });
    return resp;
}

function requestDataByCountryCode(table, country_code, type) {
    var resp;
    $.ajax({
        url: "http://localhost/skoel/api/?type="+ type +"&set=" + table + "&country_code=" + country_code,
        method: 'GET',
        async: false,
        error: function(response) {
            alert(response);
        },
        success: function(response) {
            validateRequestedData(response, table, type);
            resp = response;
        }
    });
    return resp;
}
requestDataByCountryCode('alcohol', 'NLD', 'xml');

function validateRequestedData(validString, table, type) {
    $.ajax({
        url: "http://localhost/skoel/api/validate/",
        method: 'POST',
        async: false,
        data: {
            type: type,
            validate: validString,
            table: table
        },
        error: function(response) {
            console.warn(response);
        },
        success: function(response) {
            console.log(response);
        }
    });
}

google.charts.load('current', {
    'packages':['geochart', 'corechart'],
    'mapsApiKey': 'AIzaSyBhgm7KRqMr0r1L2MrZtEECbQgOSlhHZ5E'
});
google.charts.setOnLoadCallback(drawAlcoholMap);
google.charts.setOnLoadCallback(drawHappinessMap);
google.charts.setOnLoadCallback(drawDeathsMap);

function drawAlcoholMap() {
    var dataArray = [];
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Country');
    data.addColumn('number', 'Alcohol Consumption (liters of pure alcohol)');
    var output = requestAllTableData('alcohol', 'json');
    $.each(output.countries, function(i) {
        data.addRow([output.countries[i].country.name, output.countries[i].country["alcohol-consumption"].unit]);
    })
    var options = {minValue: 0,  colors: ['#ffffff', '#00c2ff']};
    var chart = new google.visualization.GeoChart(document.getElementById('alcoholVisualizer'));
    chart.draw(data, options);
}

function drawHappinessMap() {
    var dataArray = [];
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Country');
    data.addColumn('number', 'World Rank');
    data.addColumn('number', 'Score (out of 10)');
    var output = requestAllTableData('happiness', 'json');
    $.each(output.countries, function(i) {
        data.addRow([output.countries[i].country.name, output.countries[i].country["happiness"].rank, output.countries[i].country["happiness"].score]);
    })
    var options = {minValue: 0,  colors: ['#267114', '#ffffff']};
    var chart = new google.visualization.GeoChart(document.getElementById('happinessVisualizer'));
    chart.draw(data, options);
}

function drawDeathsMap() {
    var dataArray = [];
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Country');
    data.addColumn('number', 'Deaths (per 1000 residents)');
    var output = requestAllTableData('deaths', 'json')
    $.each(output.countries, function(i) {
        data.addRow([output.countries[i].country.name, output.countries[i].country["deaths"].amount]);
    })
    var options = {minValue: 0,  colors: ['#ffffff', '#ff0000']};
    var chart = new google.visualization.GeoChart(document.getElementById('deathsVisualizer'));
    chart.draw(data, options);
}


var countries = ['NLD', 'SWE', 'RUS', 'DEU'];
$.each(countries, function(i, country) {
    var alcohol = requestDataByCountryCode('alcohol', country, 'json');
    var deaths = requestDataByCountryCode('deaths', country, 'json').countries[0].country.deaths.amount * 1000;
    var happiness = requestDataByCountryCode('happiness', country, 'json').countries[0].country.happiness.score;

    $('#countriesInDept').append('<div class="col-xl-3 col-lg-4 col-sm-6 col-12 mb-3"><div class="card mt-4 h-100"><div class="card-body text-center"><div class="display-1">'+country+'</div><h6 class="card-subtitle mb-3 text-muted">'+alcohol.countries[0].country.name+'</h6><hr><p class="card-text font-weight-bold"><i class="fas fa-glass-cheers"></i> Alcohol: <span class="font-weight-normal">'+alcohol.countries[0].country['alcohol-consumption'].unit+' Liter</span></p><p class="card-text font-weight-bold"><i class="fas fa-skull-crossbones"></i> Deaths: <span class="font-weight-normal">'+deaths+'</span></p><p class="card-text font-weight-bold"><i class="fas fa-laugh-beam"></i> Happiness: <span class="font-weight-normal" id="nlHappiness">'+happiness+'</span></p></div></div></div>');
})

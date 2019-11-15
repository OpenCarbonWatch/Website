@extends('layouts.html')

@section('content')
    <h1>Open Carbon Watch <span class="version">2019-11-17</span></h1>
    <div id="jumbo" class="row mb-5 px-0 py-0 ml-0 mr-0">
        <div class="col-md-5 px-4 py-4 mb-3 dark">
            We monitor greenhouse gases emissions reports published by public and private organizations, along with their legal obligations and their own commitments, and track them over time.
        </div>
        <div class="col-md-7 px-4 py-4 mb-3 light">
            <b>Want to help?</b> Confront organizations close to you with their obligations and commitments. Push them to action! Keep us informed of reports, obligations or engagements from other organizations in the world. Help us process the data or enhance this website. <a href="#footer">Contact&nbsp;us</a>.
        </div>
    </div>
    <div class="mb-5">
        <h2>France</h2>
        <p>In France, the <a href="https://www.legifrance.gouv.fr/affichCodeArticle.do?idArticle=LEGIARTI000031694974&cidTexte=LEGITEXT000006074220">Code de l'environnement (article L229-25)</a> states that all private organizations (employing 500 persons in mainland or 250 persons overseas) and all public organizations (employing 250 persons or spanning a population of 50,000) must perform their carbon assessment and publish it on <a href="http://www.bilans-ges.ademe.fr/">ADEME's dedicated platform</a>. This mandatory assessment includes Scope 1 and Scope 2 emissions (Scope 3 being only recommended) and must be performed at least once every 4 years for private organizations and once every 3 years for public ones. The report must be submitted along with an action plan to reduce the assessed emissions.</p>
        <p><i>The following tables are obtained by data consolidation techniques from multiples sources (see our <a href="https://github.com/OpenCarbonWatch">GitHub repositories</a> for more details). They can be considered as hints, but should by no means be interpreted as statements of whether each organization currently complies or not with the legislation.</i></p>
    </div>
@endsection

<?php

require('init.php');
htmlHeader();

// create a client instance
$client = new Solarium_Client($config);

// get a select query instance
$query = $client->createSelect();

// get the facetset component
$facetSet = $query->getFacetSet();

// create a facet field instance and set options
$facet = $facetSet->createFacetField();
$facet->setKey('stock');
$facet->setField('inStock');

// add the facet instance to the facetset
$facetSet->addFacet($facet);

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet counts for field "inStock":<br/>';
$facet = $resultset->getFacetSet()->getFacet('stock');
foreach($facet as $value => $count) {
    echo $value . ' [' . $count . ']<br/>';
}

// show documents using the resultset iterator
foreach ($resultset as $document) {

    echo '<hr/><table>';
    echo '<tr><th>id</th><td>' . $document->id . '</td></tr>';
    echo '<tr><th>name</th><td>' . $document->name . '</td></tr>';
    echo '<tr><th>price</th><td>' . $document->price . '</td></tr>';
    echo '</table>';
}

htmlFooter();
<?php

require "paginator.php";

function main()
{
    $count = getCount();
    $pager = new paginator($count);
    list($offset, $limit) = $pager->getLimit();

    $data = limit($offset, $limit);
    $pageData = $pager->getResult();
    include "view.php";
}

function getCount()
{
    $data = json_decode(file_get_contents("data.json"));
    return count($data);
}
function limit($offset, $limit)
{
    $data = json_decode(file_get_contents("data.json"));
    return array_slice($data, $offset, $limit);
}

main();

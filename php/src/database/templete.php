<?php

function createPlaceholderCard($color): string
{
    return <<<HTML
    <div class="col-xl-3 col-md-6 mb-4 hover-card" data-toggle="modal" data-target="#myModal">
        <div class="card border-left-{$color} shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-{$color} text-uppercase mb-1">
                            Please click insert price today
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Click here
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    HTML;
}

function createCard($color, $price, $price_unit_eng, $price_unit_loc, $weight_unit_eng, $weight_unit_loc, $create_date): string
{
    return <<<HTML
    <div class="col-xl-3 col-md-6 mb-4 hover-card" data-toggle="modal" data-target="#myModal">
        <div class="card border-left-{$color} shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-{$color} text-uppercase mb-1">
                            {$create_date}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {$price} {$price_unit_loc} ({$price_unit_eng}) / {$weight_unit_loc} ({$weight_unit_eng})
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    HTML;
}

?>
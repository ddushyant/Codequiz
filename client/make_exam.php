<?php include('header.php'); ?>




<div class="col-xs-3">
<select style="display: none;" name="herolist" value="X-Men" class="select-block">
<option value="0">Choose hero</option>
<option value="1">Spider Man</option>
<option value="2">Wolverine</option>
<option value="3">Captain America</option>
<option value="X-Men" selected="selected">X-Men</option>
<option value="Crocodile">Crocodile</option>
</select>
<div class="btn-group select select-block">
<button class="btn dropdown-toggle clearfix btn-primary" data-toggle="dropdown"><span class="filter-option pull-left">X-Men</span>&nbsp;<span class="caret"></span>
</button><span class="dropdown-arrow dropdown-arrow-inverse"></span>
<ul style="overflow-y: auto; min-height: 108px; max-height: 97px;" class="dropdown-menu dropdown-inverse" role="menu">
<li rel="0"><a tabindex="-1" href="#" class=""><span class="pull-left">Choose hero</span></a>
</li>
<li rel="1"><a tabindex="-1" href="#" class=""><span class="pull-left">Spider Man</span></a>
</li>
<li rel="2"><a tabindex="-1" href="#" class=""><span class="pull-left">Wolverine</span></a>
</li>
<li rel="3"><a tabindex="-1" href="#" class=""><span class="pull-left">Captain America</span></a>
</li>
<li class="selected" rel="4"><a tabindex="-1" href="#" class=""><span class="pull-left">X-Men</span></a>
</li>
<li rel="5"><a tabindex="-1" href="#" class=""><span class="pull-left">Crocodile</span></a>
</li>
</ul>
</div>
</div>

<?php
    $hiringlist = new HiringList();
?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Proforma List</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                    </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            <div class="filter-section">
              <div class="row">
                <div class="col-md-1">
                  <select name="ppage" class="ppage">
                    <option value="5" <?php echo ($hiringlist->ppage == 5) ? 'selected' : '' ?>>5</option>
                    <option value="10" <?php echo ($hiringlist->ppage == 10) ? 'selected' : '' ?>>10</option>
                    <option value="20" <?php echo ($hiringlist->ppage == 20) ? 'selected' : '' ?>>20</option>
                    <option value="50" <?php echo ($hiringlist->ppage == 50) ? 'selected' : '' ?>>50</option>
                  </select>
                </div>
                <div class="col-md-1">
                  <input type="text" name="id" class="id" value="<?php echo $hiringlist->id; ?>" placeholder="Bill ID" style="width:100%;">
                </div>
                <div class="col-md-1">
                  <input type="text" name="master_id" class="master_id" value="<?php echo $hiringlist->master_id; ?>" placeholder="Master ID" style="width:100%;">
                </div>
                <div class="col-md-2">
                  <input type="text" name="name" class="name" value="<?php echo $hiringlist->name; ?>" placeholder="Customer Name">
                </div>
                <div class="col-md-2">
                  <input type="text" name="site_name" class="site1_name" value="<?php echo $hiringlist->site_name; ?>" placeholder="Site Name">
                </div>
                <div class="col-md-2 form-group">
                  <input type="text" name="bill_from" class="datepicker bill_from form-control" value="<?php echo $hiringlist->bill_from; ?>" placeholder="Bill From">
                </div>
                <div class="col-md-2 form-group">
                  <input type="text" name="bill_to" class="datepicker bill_to form-control" value="<?php echo $hiringlist->bill_to; ?>" placeholder="Bill To">
                </div>
              </div>

              <div class="row">
                <div class="col-md-1 form-group">
                  <!-- <input type="text" name="" class="" value="<?php echo $hiringlist->financial_year; ?>" placeholder="Financial Year"> -->
                    <select name="financial_year" class="financial_year form-control">
                        <option value="-" <?php echo ($hiringlist->financial_year == '-') ? 'selected' : '' ?>>All</option>
                        <option value="2010" <?php echo ($hiringlist->financial_year == '2010') ? 'selected' : '' ?>>2010</option>
                        <option value="2011" <?php echo ($hiringlist->financial_year == '2011') ? 'selected' : '' ?>>2011</option>
                        <option value="2012" <?php echo ($hiringlist->financial_year == '2012') ? 'selected' : '' ?>>2012</option>
                        <option value="2013" <?php echo ($hiringlist->financial_year == '2013') ? 'selected' : '' ?>>2013</option>
                        <option value="2014" <?php echo ($hiringlist->financial_year == '2014') ? 'selected' : '' ?>>2014</option>
                        <option value="2015" <?php echo ($hiringlist->financial_year == '2015') ? 'selected' : '' ?>>2015</option>
                        <option value="2016" <?php echo ($hiringlist->financial_year == '2016') ? 'selected' : '' ?>>2016</option>
                        <option value="2017" <?php echo ($hiringlist->financial_year == '2017') ? 'selected' : '' ?>>2017</option>
                        <option value="2018" <?php echo ($hiringlist->financial_year == '2018') ? 'selected' : '' ?>>2018</option>
                        <option value="2019" <?php echo ($hiringlist->financial_year == '2019') ? 'selected' : '' ?>>2019</option>
                        <option value="2020" <?php echo ($hiringlist->financial_year == '2020') ? 'selected' : '' ?>>2020</option>
                        <option value="2021" <?php echo ($hiringlist->financial_year == '2021') ? 'selected' : '' ?>>2021</option>
                        <option value="2022" <?php echo ($hiringlist->financial_year == '2022') ? 'selected' : '' ?>>2022</option>
                        <option value="2023" <?php echo ($hiringlist->financial_year == '2023') ? 'selected' : '' ?>>2023</option>
                        <option value="2024" <?php echo ($hiringlist->financial_year == '2024') ? 'selected' : '' ?>>2024</option>
                        <option value="2025" <?php echo ($hiringlist->financial_year == '2025') ? 'selected' : '' ?>>2025</option>
                        <option value="2026" <?php echo ($hiringlist->financial_year == '2026') ? 'selected' : '' ?>>2026</option>
                        <option value="2027" <?php echo ($hiringlist->financial_year == '2027') ? 'selected' : '' ?>>2027</option>
                        <option value="2028" <?php echo ($hiringlist->financial_year == '2028') ? 'selected' : '' ?>>2028</option>
                        <option value="2029" <?php echo ($hiringlist->financial_year == '2029') ? 'selected' : '' ?>>2029</option>
                        <option value="2030" <?php echo ($hiringlist->financial_year == '2030') ? 'selected' : '' ?>>2030</option>
                        <option value="2031" <?php echo ($hiringlist->financial_year == '2031') ? 'selected' : '' ?>>2031</option>
                        <option value="2032" <?php echo ($hiringlist->financial_year == '2032') ? 'selected' : '' ?>>2032</option>
                        <option value="2033" <?php echo ($hiringlist->financial_year == '2033') ? 'selected' : '' ?>>2033</option>
                        <option value="2034" <?php echo ($hiringlist->financial_year == '2034') ? 'selected' : '' ?>>2034</option>
                        <option value="2035" <?php echo ($hiringlist->financial_year == '2035') ? 'selected' : '' ?>>2035</option>
                        <option value="2036" <?php echo ($hiringlist->financial_year == '2036') ? 'selected' : '' ?>>2036</option>
                        <option value="2037" <?php echo ($hiringlist->financial_year == '2037') ? 'selected' : '' ?>>2037</option>
                        <option value="2038" <?php echo ($hiringlist->financial_year == '2038') ? 'selected' : '' ?>>2038</option>
                        <option value="2039" <?php echo ($hiringlist->financial_year == '2039') ? 'selected' : '' ?>>2039</option>
                        <option value="2040" <?php echo ($hiringlist->financial_year == '2040') ? 'selected' : '' ?>>2040</option>
                        <option value="2041" <?php echo ($hiringlist->financial_year == '2041') ? 'selected' : '' ?>>2041</option>
                        <option value="2042" <?php echo ($hiringlist->financial_year == '2042') ? 'selected' : '' ?>>2042</option>
                        <option value="2043" <?php echo ($hiringlist->financial_year == '2043') ? 'selected' : '' ?>>2043</option>
                        <option value="2044" <?php echo ($hiringlist->financial_year == '2044') ? 'selected' : '' ?>>2044</option>
                        <option value="2045" <?php echo ($hiringlist->financial_year == '2045') ? 'selected' : '' ?>>2045</option>
                        <option value="2046" <?php echo ($hiringlist->financial_year == '2046') ? 'selected' : '' ?>>2046</option>
                        <option value="2047" <?php echo ($hiringlist->financial_year == '2047') ? 'selected' : '' ?>>2047</option>
                        <option value="2048" <?php echo ($hiringlist->financial_year == '2048') ? 'selected' : '' ?>>2048</option>
                        <option value="2049" <?php echo ($hiringlist->financial_year == '2049') ? 'selected' : '' ?>>2049</option>
                        <option value="2050" <?php echo ($hiringlist->financial_year == '2050') ? 'selected' : '' ?>>2050</option>
                    </select>                  
                </div>


                <div class="col-md-2 form-group">
                  <!-- <input type="text" name="" class="" value="<?php echo $hiringlist->financial_year; ?>" placeholder="Financial Year"> -->
                    <select name="bill_from_comp" class="bill_from_comp form-control">
                        <option value="-" <?php echo ($hiringlist->bill_from_comp == '-') ? 'selected' : '' ?>>All</option>
                        <?php
                            $company_list = getCompanies();
                            foreach ($company_list as $c_value) {
                                if($hiringlist->bill_from_comp == $c_value->id) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                echo '<option value="'.$c_value->id.'" '.$selected.'>'.$c_value->company_name.'</option>';
                            }
                        ?>
                        
                    </select>                  
                </div>

                <div class="col-md-1">
                  <input type="text" name="ref_number" class="ref_number" value="<?php echo $depositlist->ref_number; ?>" placeholder="Ref. Number" style="width:100%;">
                </div>

              </div>

              
              <input type="hidden" name="filter_action" class="filter_action" value="proforma_filter">
            </div>
        </div>
        <div class="proforma_filter">
        <?php
            include( get_template_directory().'/admin/report/hiring/ajax_loading/proforma_list.php' );
        ?>
        </div>
    </div>
</div>
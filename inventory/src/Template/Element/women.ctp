<div class="tab-content women" style="width: 100%;float: left;">
    <?= $this->Form->input('profile_type', ['value' => '2', 'type' => 'hidden', 'class' => "form-control", 'required' => "required", 'label' => false]); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Product Category <sup style="color:red;">*</sup></label>
                                            <select name="product_type" class="form-control"  onchange="getSubCatg(this.value);" required  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?> >
                                                <option value="" selected disabled>Select Category</option>
                                                <?php foreach ($productType as $type) { ?>
                                                    <option  value="<?php echo $type->id; ?>" <?php echo (!empty($editproduct) && ($editproduct->product_type == $type->id)) ? "selected" : "";  echo (!empty($_GET['ctg']) && ($_GET['ctg'] ==$type->id))?'selected':''; ?> ><?php echo $type->product_type . '-' . $type->name; ?></option>
    <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Sub-category <sup style="color:red;">*</sup></label>
                                            <select name="rack" class="form-control" required onchange="setSubCatg(this.value);"  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?>>
                                                <?php /*if (empty($editproduct)) { ?> 
                                                    <option value="" selected disabled>Select Category first</option>
                                                <?php }*/ ?>
                                                    <option value='' selected disabled>--</option>
                                                <?php
                                                if (!empty($in_rack)) {
                                                    foreach ($in_rack as $rk) {
                                                        ?>
                                                        <option  value="<?php echo $rk->id; ?>"  <?php echo (!empty($editproduct) && ($editproduct->rack == $rk->id)) ? "selected" : ""; ?> ><?php echo $rk->rack_name; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

<?php if(!empty($_GET['sub_ctg']) || (!empty($editproduct) && !empty($editproduct->rack)) ){ ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Product Name 1 <sup style="color:red;">*</sup></label>
    <?= $this->Form->input('product_name_one', ['value' => @$editproduct->product_name_one, 'type' => 'text', 'class' => "form-control", 'label' => false, 'placeholder' => 'Please enter product name 1', 'required', 'maxlength' => "40"]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="display:none;">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Product Name 2</label>
    <?= $this->Form->input('product_name_two', ['value' => @$editproduct->product_name_two, 'type' => 'text', 'class' => "form-control", 'label' => false, 'placeholder' => 'Please enter product name 2', 'maxlength' => "40"]); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Height range <sup style="color:red;">*</sup></label>
                                            <div class="women-select-boxes">
                                                <div class="women-select1">
                                                    <select name="tall_feet"  id="tall_feet" class="form-control" required>
                                                        <option <?php if (@$editproduct->tall_feet == '') { ?> selected=""<?php } ?> value="" disabled>--</option>
                                                        <option <?php if (@$editproduct->tall_feet == '4') { ?> selected=""<?php } ?>value="4">4</option>
                                                        <option <?php if (@$editproduct->tall_feet == '5') { ?> selected=""<?php } ?> value="5">5</option>
                                                        <option <?php if (@$editproduct->tall_feet == '6') { ?> selected=""<?php } ?> value="6">6</option>
                                                    </select>
                                                    <label>ft.</label>
                                                </div>
                                                <div class="women-select1">
                                                    <select name="tall_inch" id="tall_inch" class="form-control">
                                                        <option <?php if (@$editproduct->tall_inch == '') { ?> selected=""<?php } ?> value="" disabled>--</option>
                                                        <option <?php if (@$editproduct->tall_inch == '0') { ?> selected=""<?php } ?> value="0">0</option>
                                                        <option <?php if (@$editproduct->tall_inch == '1') { ?> selected=""<?php } ?> value="1">1</option>
                                                        <option <?php if (@$editproduct->tall_inch == '2') { ?> selected=""<?php } ?>value="2">2</option>
                                                        <option <?php if (@$editproduct->tall_inch == '3') { ?> selected=""<?php } ?>value="3">3</option>
                                                        <option <?php if (@$editproduct->tall_inch == '4') { ?> selected=""<?php } ?> value="4">4</option>
                                                        <option <?php if (@$editproduct->tall_inch == '5') { ?> selected=""<?php } ?>value="5">5</option>
                                                        <option <?php if (@$editproduct->tall_inch == '6') { ?> selected=""<?php } ?> value="6">6</option>
                                                        <option <?php if (@$editproduct->tall_inch == '7') { ?> selected=""<?php } ?> value="7">7</option>
                                                        <option <?php if (@$editproduct->tall_inch == '8') { ?> selected=""<?php } ?> value="8">8</option>
                                                        <option <?php if (@$editproduct->tall_inch == '9') { ?> selected=""<?php } ?> value="9">9</option>
                                                        <option <?php if (@$editproduct->tall_inch == '10') { ?> selected=""<?php } ?> value="10">10</option>
                                                        <option <?php if (@$editproduct->tall_inch == '11') { ?> selected=""<?php } ?> value="11">11</option>
                                                    </select>

    <?= $this->Form->input('id', ['value' => @$editproduct->id, 'type' => 'hidden', 'class' => "form-control", 'required' => "required", 'label' => false]); ?>
                                                </div>
                                                <span>to</span>
                                                <div class="women-select1">

                                                    <select name="tall_feet2"  id="tall_feet2" class="form-control" required>
                                                        <option <?php if (@$editproduct->tall_feet2 == '') { ?> selected=""<?php } ?> value="" disabled>--</option>
                                                        <option <?php if (@$editproduct->tall_feet2 == '4') { ?> selected=""<?php } ?>value="4">4</option>
                                                        <option <?php if (@$editproduct->tall_feet2 == '5') { ?> selected=""<?php } ?> value="5">5</option>
                                                        <option <?php if (@$editproduct->tall_feet2 == '6') { ?> selected=""<?php } ?> value="6">6</option>
                                                    </select>
                                                    <label>ft.</label>
                                                </div>
                                                <div class="women-select1">
                                                    <select name="tall_inch2" id="tall_inch2" class="form-control">
                                                        <option <?php if (@$editproduct->tall_inch2 == '') { ?> selected=""<?php } ?> value="" disabled>--</option>
                                                        <option <?php if (@$editproduct->tall_inch2 == '0') { ?> selected=""<?php } ?> value="0">0</option>
                                                        <option <?php if (@$editproduct->tall_inch2 == '1') { ?> selected=""<?php } ?> value="1">1</option>
                                                        <option <?php if (@$editproduct->tall_inch2 == '2') { ?> selected=""<?php } ?>value="2">2</option>
                                                        <option <?php if (@$editproduct->tall_inch2 == '3') { ?> selected=""<?php } ?>value="3">3</option>
                                                        <option <?php if (@$editproduct->tall_inch2 == '4') { ?> selected=""<?php } ?> value="4">4</option>
                                                        <option <?php if (@$editproduct->tall_inch2 == '5') { ?> selected=""<?php } ?>value="5">5</option>
                                                        <option <?php if (@$editproduct->tall_inch2 == '6') { ?> selected=""<?php } ?> value="6">6</option>
                                                        <option <?php if (@$editproduct->tall_inch2 == '7') { ?> selected=""<?php } ?> value="7">7</option>
                                                        <option <?php if (@$editproduct->tall_inch2 == '8') { ?> selected=""<?php } ?> value="8">8</option>
                                                        <option <?php if (@$editproduct->tall_inch2 == '9') { ?> selected=""<?php } ?> value="9">9</option>
                                                        <option <?php if (@$editproduct->tall_inch2 == '10') { ?> selected=""<?php } ?> value="10">10</option>
                                                        <option <?php if (@$editproduct->tall_inch2 == '11') { ?> selected=""<?php } ?> value="11">11</option>
                                                    </select>

    <?= $this->Form->input('id', ['value' => @$editproduct->id, 'type' => 'hidden', 'class' => "form-control", 'required' => "required", 'label' => false]); ?>
                                                </div>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Weight range <sup style="color:red;">*</sup></label>
                                            <div class="women-select-boxes">
                                                <div class="women-select2">
    <?= $this->Form->input('best_fit_for_weight', ['value' => @$editproduct->best_fit_for_weight, 'type' => 'text', 'class' => "form-control", 'label' => false, 'placeholder' => 'Please enter your weight','required']); ?>                                                            
                                                </div>
                                                <span>to</span>
                                                <div class="women-select2">
    <?= $this->Form->input('best_fit_for_weight2', ['value' => @$editproduct->best_fit_for_weight2, 'type' => 'text', 'class' => "form-control", 'label' => false, 'placeholder' => 'Please enter your weight', 'required']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Age range <sup style="color:red;">*</sup></label>
                                            <div class="women-select-boxes">
                                                <div class="women-select2">
    <?= $this->Form->input('age1', ['value' => @$editproduct->age1, 'type' => 'text', 'class' => "form-control", 'label' => false, 'placeholder' => 'Please enter age','required']); ?>                                                            
                                                </div>
                                                <span>to</span>
                                                <div class="women-select2">
    <?= $this->Form->input('age2', ['value' => @$editproduct->age2, 'type' => 'text', 'class' => "form-control", 'label' => false, 'placeholder' => 'Please enter age','required']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Season <sup style="color:red;">*</sup></label>
                                            <ul id="seson" class="list-inline">
                                                <li><input id="selectAllseson" type="checkbox" <?php if (!empty($editproduct->season) && in_array($al_ses_li, json_decode($editproduct->season, true))) { ?> checked <?php } ?> /><label for='selectAllseson<?= $ky; ?>'><?= $al_ses_li; ?>Select All</label></li>
                                                <?php
                                                $all_seson = ['Spring', 'Summer', 'Fall', 'Winter'];
                                                foreach ($all_seson as $ky => $al_ses_li) {
                                                    ?>
                                                    <li><input id="all_seso<?= $ky; ?>" type="checkbox" name="season[]" value="<?= $al_ses_li; ?>"  <?php if (!empty($editproduct->season) && in_array($al_ses_li, json_decode($editproduct->season, true))) { ?> checked <?php } ?> /><label for="all_seso<?= $ky; ?>"><?= $al_ses_li; ?></label></li>
    <?php } ?>                                                        
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Profession</label>
                                            <select name="profession[]" id="profession" class="form-control select2_select" aria-invalid="false" multiple>
                                                <option value="" <?php if (!empty($editproduct->profession) && in_array('NULL', json_decode($editproduct->profession, true))) { ?> selected <?php } ?> >--</option>
                                                <option value="1" <?php if (!empty($editproduct->profession) && in_array(1, json_decode($editproduct->profession, true))) { ?> selected <?php } ?> >Architecture / Engineering</option>
                                                <option value="2" <?php if (!empty($editproduct->profession) && in_array(2, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Art / Design</option>
                                                <option value="3" <?php if (!empty($editproduct->profession) && in_array(3, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Building / Maintenance</option>
                                                <option value="4" <?php if (!empty($editproduct->profession) && in_array(4, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Business / Client Service</option>
                                                <option value="5" <?php if (!empty($editproduct->profession) && in_array(5, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Community / Social Service</option>
                                                <option value="6" <?php if (!empty($editproduct->profession) && in_array(6, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Computer / IT</option>
                                                <option value="7" <?php if (!empty($editproduct->profession) && in_array(7, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Education</option>
                                                <option value="8" <?php if (!empty($editproduct->profession) && in_array(8, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Entertainer / Performer</option>
                                                <option value="9" <?php if (!empty($editproduct->profession) && in_array(9, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Farming / Fishing / Forestry</option>
                                                <option value="10" <?php if (!empty($editproduct->profession) && in_array(10, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Financial Services</option>
                                                <option value="11" <?php if (!empty($editproduct->profession) && in_array(11, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Health Practitioner / Technician</option>
                                                <option value="12" <?php if (!empty($editproduct->profession) && in_array(12, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Hospitality / Food Service</option>
                                                <option value="13" <?php if (!empty($editproduct->profession) && in_array(13, json_decode($editproduct->profession, true))) { ?> selected <?php } ?> >Management</option>
                                                <option value="14" <?php if (!empty($editproduct->profession) && in_array(14, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Media / Communications</option>
                                                <option value="15" <?php if (!empty($editproduct->profession) && in_array(15, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Military / Protective Service</option>
                                                <option value="16" <?php if (!empty($editproduct->profession) && in_array(16, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Legal</option>
                                                <option value="17" <?php if (!empty($editproduct->profession) && in_array(17, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Office / Administration</option>
                                                <option value="18" <?php if (!empty($editproduct->profession) && in_array(18, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Average</option>
                                                <option value="19" <?php if (!empty($editproduct->profession) && in_array(19, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Personal Care & Service</option>
                                                <option value="20" <?php if (!empty($editproduct->profession) && in_array(20, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Production / Manufacturing</option>
                                                <option value="21" <?php if (!empty($editproduct->profession) && in_array(21, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Retail</option>
                                                <option value="22" <?php if (!empty($editproduct->profession) && in_array(22, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Sales</option>
                                                <option value="23" <?php if (!empty($editproduct->profession) && in_array(23, json_decode($editproduct->profession, true))) { ?> selected <?php } ?> >Science</option>
                                                <option value="24" <?php if (!empty($editproduct->profession) && in_array(24, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Technology</option>
                                                <option value="25" <?php if (!empty($editproduct->profession) && in_array(25, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Transportation</option>
                                                <option value="26" <?php if (!empty($editproduct->profession) && in_array(26, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Self-Employed</option>
                                                <option value="27" <?php if (!empty($editproduct->profession) && in_array(27, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Stay-At-Home Parent</option>
                                                <option value="28" <?php if (!empty($editproduct->profession) && in_array(28, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Student</option>
                                                <option value="29" <?php if (!empty($editproduct->profession) && in_array(29, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Retired</option>
                                                <option value="30" <?php if (!empty($editproduct->profession) && in_array(30, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Not Employed</option>
                                                <option value="31" <?php if (!empty($editproduct->profession) && in_array(31, json_decode($editproduct->profession, true))) { ?> selected <?php } ?>>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Occasions</label>
                                            <select name="occasional_dress[]" id="occasional_dress"  class="form-control select2_select" aria-invalid="false" multiple>
                                                <option value="" <?php if (!empty($editproduct->occasional_dress) && in_array('NULL', json_decode($editproduct->occasional_dress, true))) { ?> selected <?php } ?>>--</option>
                                                <option value="1"  <?php if (!empty($editproduct->occasional_dress) && in_array(1, json_decode($editproduct->occasional_dress, true))) { ?> selected <?php } ?>>Business Casual / Work</option>
                                                <option value="2"  <?php if (!empty($editproduct->occasional_dress) && in_array(2, json_decode($editproduct->occasional_dress, true))) { ?> selected <?php } ?>>Cocktail / Wedding / Special</option>
                                                <?php /* ?>
                                                  <option value="3"  <?php if(!empty($editproduct->occasional_dress) && in_array(3, json_decode($editproduct->occasional_dress,true))){ ?> selected <?php } ?>>Building / Maintenance</option>
                                                  <?php */ ?>
                                                <option value="4"  <?php if (!empty($editproduct->occasional_dress) && in_array(4, json_decode($editproduct->occasional_dress, true))) { ?> selected <?php } ?>>Most of the time</option>
                                                <option value="5"  <?php if (!empty($editproduct->occasional_dress) && in_array(5, json_decode($editproduct->occasional_dress, true))) { ?> selected <?php } ?>>Around once or twice a month</option>
                                                <option value="6"  <?php if (!empty($editproduct->occasional_dress) && in_array(6, json_decode($editproduct->occasional_dress, true))) { ?> selected <?php } ?>>Date Night / Night Out</option>
                                                <option value="7"  <?php if (!empty($editproduct->occasional_dress) && in_array(7, json_decode($editproduct->occasional_dress, true))) { ?> selected <?php } ?>>Laid Back Casual</option>
                                                <option value="8"  <?php if (!empty($editproduct->occasional_dress) && in_array(8, json_decode($editproduct->occasional_dress, true))) { ?> selected <?php } ?>>Rarely</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12 col-md-12 type-box women-type-box body-women">
                                        <h3>What's your body type?</h3>
                                        <ul>
                                            <li>
                                                <h4 style="margin-top: 0;">Inverted Triangle</h4>
                                                <input class="radio-box" id="radio2" name="better_body_shape[]" value="2" type="checkbox" <?php if (!empty($editproduct->better_body_shape) && in_array(2, json_decode($editproduct->better_body_shape, true))) { ?> checked <?php } ?>>
                                                <label for="radio2">
                                                    <img src="<?= HTTP_ROOT_BASE; ?>images/inverted-triangle.jpg" alt="">
                                                </label>
                                            </li>
                                            <li>
                                                <h4 style="margin-top: 0;">Triangle</h4>
                                                <input class="radio-box" id="radio3" type="checkbox" name="better_body_shape[]" value="3" <?php if (!empty($editproduct->better_body_shape) && in_array(3, json_decode($editproduct->better_body_shape, true))) { ?> checked <?php } ?>>
                                                <label for="radio3">
                                                    <img src="<?= HTTP_ROOT_BASE; ?>images/triangle.jpg" alt="">
                                                </label>
                                            </li>
                                            <li>
                                                <h4 style="margin-top: 0;">rectangle</h4>
                                                <input class="radio-box" name="better_body_shape[]" value="1" id="radio1" type="checkbox"  <?php if (!empty($editproduct->better_body_shape) && in_array(1, json_decode($editproduct->better_body_shape, true))) { ?> checked <?php } ?>>
                                                <label for="radio1">
                                                    <img src="<?= HTTP_ROOT_BASE; ?>images/rectangle.jpg" alt="">
                                                </label>
                                            </li>
                                            <li>
                                                <h4 style="margin-top: 0;">hourglass</h4>
                                                <input class="radio-box" id="radio4" type="checkbox" name="better_body_shape[]" value="4"  <?php if (!empty($editproduct->better_body_shape) && in_array(4, json_decode($editproduct->better_body_shape, true))) { ?> checked <?php } ?>>
                                                <label for="radio4">
                                                    <img src="<?= HTTP_ROOT_BASE; ?>images/hourglass.jpg" alt="">
                                                </label>
                                            </li>
                                            <li>
                                                <h4 style="margin-top: 0;">Apple</h4>
                                                <input class="radio-box" id="radio4z" type="checkbox" name="better_body_shape[]" value="5"  <?php if (!empty($editproduct->better_body_shape) && in_array(5, json_decode($editproduct->better_body_shape, true))) { ?> checked <?php } ?>>
                                                <label for="radio4z">
                                                    <img src="<?= HTTP_ROOT_BASE; ?>images/apple.jpg" alt="">
                                                </label>
                                            </li>
                                        </ul>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Brand Name <sup style="color:red;">*</sup></label>
                                            <select name="brand_id" id="brand_id" class="form-control" required>
                                                <option value="" selected disabled>--</option>
                                                <?php
                                                foreach ($brandsListings as $brandnm) {
                                                    if (empty(@$editproduct) && ($brandnm->is_active != 0)) {
                                                        ?>

                                                        <option <?php if ($brandnm->id == @$editproduct->brand_id) { ?> selected=""<?php } ?> value="<?php echo $brandnm->id; ?>"><?php echo $brandnm->brand_name; ?></option>
                                                        <?php
                                                    }
                                                    if (!empty(@$editproduct)) {
                                                        ?>

                                                        <option <?php if ($brandnm->id == @$editproduct->brand_id) { ?> selected=""<?php } ?> value="<?php echo $brandnm->id; ?>"><?php echo $brandnm->brand_name; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Color ? <sup style="color:red;">*</sup></label>
                                            <select name="color" class="form-control" required>

                                                <option <?php if (empty($editproduct->color)) { ?> selected="" <?php } ?> value="" disabled>--</option>
                                                <?php foreach ($color_arr as $indx => $clr) { ?>
                                                    <option <?php if (@$editproduct->color == $indx) { ?> selected="" <?php } ?> value="<?= $indx; ?>"><?= $clr; ?></option>
    <?php } ?> 
                                            </select>
                                        </div>
                                    </div>
                                    <?php if(in_array($product_ctg_nme,["A14"]) && in_array($product_sub_ctg_nme, ["A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412", "A1413"])){ ?>
                                    <div class="col-md-6 "    >
                                        <div class="form-group" style="margin-top: 35px;">

                                            <label for="free_size_wo">
                                                <input type="radio" name="primary_size" value="free_size" <?= (!empty($editproduct) && ($editproduct->primary_size == 'free_size')) ? 'checked' : 'checked'; ?> id="free_size_wo" required/>
                                                Free Size  <sup style="color:red;">*</sup>
                                            </label>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <div class="col-md-6 women-size-prefer">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">What size you prefer?</label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row"  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?>>
                                                        <?php/* if(in_array($product_ctg_nme,["A4"]) || in_array($product_sub_ctg_nme, ["A41", "A42", "A47", "A46"])){ ?>
                                                        <div class="col-md-1"   >
                                                            <input type="radio" name="primary_size" value="paint_size" <?= (!empty($editproduct) && ($editproduct->primary_size == 'paint_size')) ? 'checked' : ''; ?> required/>
                                                        </div>
                                                        <div class="col-sm-4"  >
                                                            <label>PANTS  <sup style="color:red;">*</sup></label>
                                                            <select name="pants" id="pants" required  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?> >
                                                                <option <?php if (@$editproduct->pants == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                <optgroup label="Women's Sizes">
                                                                    <option <?php if (@$editproduct->pants == '00') { ?> selected="" <?php } ?> value="00">00</option>
                                                                    <option <?php if (@$editproduct->pants == '00') { ?> selected="" <?php } ?> value="00">00</option>
                                                                    <option <?php if (@$editproduct->pants == '0') { ?> selected="" <?php } ?> value="0">0</option>
                                                                    <option <?php if (@$editproduct->pants == '2') { ?> selected="" <?php } ?> value="2">2</option>
                                                                    <option <?php if (@$editproduct->pants == '4') { ?> selected="" <?php } ?> value="4">4</option>
                                                                    <option <?php if (@$editproduct->pants == '6') { ?> selected="" <?php } ?> value="6">6</option>
                                                                    <option <?php if (@$editproduct->pants == '8') { ?> selected="" <?php } ?> value="8">8</option>
                                                                    <option <?php if (@$editproduct->pants == '10') { ?> selected="" <?php } ?> value="10">10</option>
                                                                    <option <?php if (@$editproduct->pants == '12') { ?> selected="" <?php } ?> value="12">12</option>
                                                                    <option <?php if (@$editproduct->pants == '14') { ?> selected="" <?php } ?> value="14">14</option>
                                                                    <option <?php if (@$editproduct->pants == '16') { ?> selected="" <?php } ?> value="16">16</option>
                                                                </optgroup>
                                                                <optgroup label="Women's Plus Sizes">
                                                                    <option <?php if (@$editproduct->pants == '14W') { ?> selected="" <?php } ?> value="14W">14W</option>
                                                                    <option <?php if (@$editproduct->pants == '16W') { ?> selected="" <?php } ?> value="16W">16W</option>
                                                                    <option <?php if (@$editproduct->pants == '18W') { ?> selected="" <?php } ?> value="18W">18W</option>
                                                                    <option <?php if (@$editproduct->pants == '20W') { ?> selected="" <?php } ?> value="20W">20W</option>
                                                                    <option <?php if (@$editproduct->pants == '22W') { ?> selected="" <?php } ?> value="22W">22W</option>
                                                                    <option <?php if (@$editproduct->pants == '24W') { ?> selected="" <?php } ?> value="24W">24W</option>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                        <?php }*/ ?>
                                                        
                                                        <?php /*if(in_array($product_ctg_nme,["A4"]) || in_array($product_sub_ctg_nme, ["A44", "A46"])){ ?>
                                                        <div class="col-sm-6">
                                                            <label>BRA SIZE  <sup style="color:red;">*</sup></label> 
                                                            <div class="row">
                                                                <div class="col-md-1">
                                                                    <input type="radio" name="primary_size" value="bra_size" <?= (!empty($editproduct) && ($editproduct->primary_size == 'bra_size')) ? 'checked' : ''; ?> required/>
                                                                </div>
                                                                <div class="col-sm-4">                                                                        
                                                                    <select name="bra" id="bra" required  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?>>
                                                                        <option <?php if (@$editproduct->bra == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                        <option <?php if (@$editproduct->bra == '30') { ?> selected="" <?php } ?> value="30">30</option>
                                                                        <option <?php if (@$editproduct->bra == '32') { ?> selected="" <?php } ?> value="32">32</option>
                                                                        <option <?php if (@$editproduct->bra == '34') { ?> selected="" <?php } ?> value="34">34</option>
                                                                        <option <?php if (@$editproduct->bra == '36') { ?> selected="" <?php } ?> value="36">36</option>
                                                                        <option <?php if (@$editproduct->bra == '38') { ?> selected="" <?php } ?> value="38">38</option>
                                                                        <option <?php if (@$editproduct->bra == '40') { ?> selected="" <?php } ?> value="40">40</option>
                                                                        <option <?php if (@$editproduct->bra == '42') { ?> selected="" <?php } ?> value="42">42</option>
                                                                        <option <?php if (@$editproduct->bra == '44') { ?> selected="" <?php } ?> value="44">44</option>
                                                                        <option <?php if (@$editproduct->bra == '46') { ?> selected="" <?php } ?> value="46">46</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <select name="bra_recomend" id="bra_recomend">
                                                                        <option <?php if (@$editproduct->bra_recomend == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'AA') { ?> selected="" <?php } ?> value="AA">AA</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'A') { ?> selected="" <?php } ?> value="A">A</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'B') { ?> selected="" <?php } ?> value="B">B</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'C') { ?> selected="" <?php } ?> value="C">C</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'D') { ?> selected="" <?php } ?> value="D">D</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'DD') { ?> selected="" <?php } ?> value="DD">DD</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'DDD') { ?> selected="" <?php } ?> value="DDD">DDD</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'F') { ?> selected="" <?php } ?> value="F">F</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'G') { ?> selected="" <?php } ?> value="G">G</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'H') { ?> selected="" <?php } ?> value="H">H</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php }*/ ?>
                                                    </div>

                                                    <div class="row" >
                                                        <?php if(in_array($product_ctg_nme,["A6"])){ ?>
                                                        <div class="col-md-1"  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?> >
                                                            <input type="radio" name="primary_size" value="skirt_size" <?= (!empty($editproduct) && ($editproduct->primary_size == 'skirt_size')) ? 'checked' : ''; ?> required />
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <label>SKIRT SIZE  <sup style="color:red;">*</sup></label>
                                                            <select name="skirt" id="skirt" required  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?> >
                                                                <option <?php if (@$editproduct->skirt == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                <option <?php if (@$editproduct->skirt == 'XXS') { ?> selected="" <?php } ?> value="XXS">XXS</option>
                                                                <option <?php if (@$editproduct->skirt == 'XS') { ?> selected="" <?php } ?> value="XS">XS</option>
                                                                <option <?php if (@$editproduct->skirt == 'S') { ?> selected="" <?php } ?> value="S">S</option>
                                                                <option <?php if (@$editproduct->skirt == 'M') { ?> selected="" <?php } ?> value="M">M</option>
                                                                <option <?php if (@$editproduct->skirt == 'L') { ?> selected="" <?php } ?> value="L">L</option>
                                                                <option <?php if (@$editproduct->skirt == 'XL') { ?> selected="" <?php } ?> value="XL">XL</option>
                                                                <option <?php if (@$editproduct->skirt == 'XXL') { ?> selected="" <?php } ?> value="XXL">XXL</option>
                                                                <option <?php if (@$editproduct->skirt == '1X') { ?> selected="" <?php } ?> value="1X">1X</option>
                                                                <option <?php if (@$editproduct->skirt == '2X') { ?> selected="" <?php } ?> value="2X">2X</option>
                                                                <option <?php if (@$editproduct->skirt == '3X') { ?> selected="" <?php } ?> value="3X">3X</option>
                                                                <option <?php if (@$editproduct->skirt == '4X') { ?> selected="" <?php } ?> value="4X">4X</option>
                                                            </select>
                                                        </div>
                                                        <?php } ?>
                                                        
                                                        <?php if(in_array($product_ctg_nme,["A4","A5", "A7", "A8", "A10"])){ ?>
                                                        <div class="col-sm-6"   >
                                                            <select id="prd_sz_typ" class="form-control" required onchange="prdsztyp(this.value)"  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?>>
                                                                <option value="" selected disabled>----</option>
                                                                <?php if(in_array($product_ctg_nme,["A4", "A5", "A7", "A8"])){ ?>
                                                                <option value="wo_bottom"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'wo_bottom')) ? 'selected' : ''; ?> >BOTTOM SIZE</option>
                                                                <?php } ?>
                                                                
                                                                <?php if(in_array($product_ctg_nme,["A5", "A7", "A8"])){ ?>
                                                                <option value="jeans"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'jeans')) ? 'selected' : ''; ?>  >JEANS SIZE</option>
                                                                <?php } ?>
                                                                
                                                                <?php if(in_array($product_ctg_nme,["A4", "A8"])){ ?>
                                                                <option value="paint_size"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'paint_size')) ? 'selected' : ''; ?>  >PANT SIZE</option>
                                                                <?php } ?>
                                                                
                                                                <?php if(in_array($product_ctg_nme,["A4", "A10"])){ ?>
                                                                <option value="blouse_size"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'blouse_size')) ? 'selected' : ''; ?> >SHIRT & BLOUSE</option>
                                                                <option value="wo_jackect_size"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'wo_jackect_size')) ? 'selected' : ''; ?> >JACKET SIZE</option>
                                                                <?php } ?>
                                                                <?php if(in_array($product_ctg_nme,["A4"])){ ?>
                                                                <option value="bra_size"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'bra_size')) ? 'selected' : ''; ?> >Bra Size</option>
                                                                <option value="active_wr"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'active_wr')) ? 'selected' : ''; ?> >ACTIVE WEAR SIZE</option>
                                                                <option value="dress_size"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'dress_size')) ? 'selected' : ''; ?> >DRESS SIZE</option>
                                                               
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6"   id="prd_sz_typ_div"  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?>>
                                                            
                                                        </div>
                                                        <?php if(!empty($editproduct) && ($editproduct->primary_size == 'wo_bottom')){ ?>
                                                            <script>
                                                                $(document).ready(function(){
                                                                    prdsztyp('<?=$editproduct->primary_size;?>');
                                                                })
                                                            </script>
                                                        <?php } ?>
                                                        <?php if(!empty($editproduct) && ($editproduct->primary_size == 'jeans')){ ?>
                                                            <script>
                                                                $(document).ready(function(){
                                                                    prdsztyp('<?=$editproduct->primary_size;?>');
                                                                })
                                                            </script>
                                                        <?php } ?>
                                                        <?php if(!empty($editproduct) && ($editproduct->primary_size == 'paint_size')){ ?>
                                                            <script>
                                                                $(document).ready(function(){
                                                                    prdsztyp('<?=$editproduct->primary_size;?>');
                                                                })
                                                            </script>
                                                        <?php } ?>
                                                            <?php if(!empty($editproduct) && ($editproduct->primary_size == 'blouse_size')){ ?>
                                                            <script>
                                                                $(document).ready(function(){
                                                                    prdsztyp('<?=$editproduct->primary_size;?>');
                                                                })
                                                            </script>
                                                        <?php } ?>
                                                            <?php if(!empty($editproduct) && ($editproduct->primary_size == 'bra_size')){ ?>
                                                            <script>
                                                                $(document).ready(function(){
                                                                    prdsztyp('<?=$editproduct->primary_size;?>');
                                                                })
                                                            </script>
                                                        <?php } ?>
                                                            <?php if(!empty($editproduct) && ($editproduct->primary_size == 'active_wr')){ ?>
                                                            <script>
                                                                $(document).ready(function(){
                                                                    prdsztyp('<?=$editproduct->primary_size;?>');
                                                                })
                                                            </script>
                                                        <?php } ?>
                                                            <?php if(!empty($editproduct) && ($editproduct->primary_size == 'wo_jackect_size')){ ?>
                                                            <script>
                                                                $(document).ready(function(){
                                                                    prdsztyp('<?=$editproduct->primary_size;?>');
                                                                })
                                                            </script>
                                                        <?php } ?>
                                                            <?php if(!empty($editproduct) && ($editproduct->primary_size == 'dress_size')){ ?>
                                                            <script>
                                                                $(document).ready(function(){
                                                                    prdsztyp('<?=$editproduct->primary_size;?>');
                                                                })
                                                            </script>
                                                        <?php } ?>
                                                        <script>
                                                            function prdsztyp(data){
                                                                let selectSizeAcc = ``;
                                                                if(data == 'jeans' ){
                                                                    selectSizeAcc = `<div>
                                                            <label>JEANS SIZE  <sup style="color:red;">*</sup></label>
                                                            <div class="col-md-1">
                                                                <input type="radio" name="primary_size" value="jeans"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'jeans')) ? 'checked' : 'checked'; ?> required/>
                                                            </div>
                                                            <div class="col-md-11">
                                                                <select name="jeans" id="jeans" required>
                                                                    <option <?php if (@$editproduct->jeans == '') { ?> selected="" <?php } ?> value="" selected="selected">--</option>
                                                                    <optgroup label="Women's Sizes">
                                                                        <option <?php if (@$editproduct->jeans == '00') { ?> selected="" <?php } ?> value="00">00</option>
                                                                        <option <?php if (@$editproduct->jeans == '0') { ?> selected="" <?php } ?> value="0">0</option>
                                                                        <option <?php if (@$editproduct->jeans == '2') { ?> selected="" <?php } ?> value="2">2</option>
                                                                        <option <?php if (@$editproduct->jeans == '4') { ?> selected="" <?php } ?> value="4">4</option>
                                                                        <option <?php if (@$editproduct->jeans == '6') { ?> selected="" <?php } ?> value="6">6</option>
                                                                        <option <?php if (@$editproduct->jeans == '8') { ?> selected="" <?php } ?> value="8">8</option>
                                                                        <option <?php if (@$editproduct->jeans == '10') { ?> selected="" <?php } ?> value="10">10</option>
                                                                        <option <?php if (@$editproduct->jeans == '12') { ?> selected="" <?php } ?> value="12">12</option>
                                                                        <option <?php if (@$editproduct->jeans == '14') { ?> selected="" <?php } ?> value="14">14</option>
                                                                        <option <?php if (@$editproduct->jeans == '16') { ?> selected="" <?php } ?> value="16">16</option>
                                                                    </optgroup>
                                                                    <optgroup label="Women's Plus Sizes">
                                                                        <option <?php if (@$editproduct->jeans == '14W') { ?> selected="" <?php } ?> value="14W">14W</option>
                                                                        <option <?php if (@$editproduct->jeans == '16W') { ?> selected="" <?php } ?> value="16W">16W</option>
                                                                        <option <?php if (@$editproduct->jeans == '18W') { ?> selected="" <?php } ?> value="18W">18W</option>
                                                                        <option <?php if (@$editproduct->jeans == '20W') { ?> selected="" <?php } ?> value="20W">20W</option>
                                                                        <option <?php if (@$editproduct->jeans == '22W') { ?> selected="" <?php } ?> value="22W">22W</option>
                                                                        <option <?php if (@$editproduct->jeans == '24W') { ?> selected="" <?php } ?> value="24W">24W</option>
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                        </div>`;
                                                                }
                                                                if(data == 'wo_bottom' ){
                                                                    selectSizeAcc = `<div>
                                                            <label>BOTTOM SIZE  <sup style="color:red;">*</sup></label>
                                                            <div class="col-md-1">
                                                                <input type="radio" name="primary_size" value="wo_bottom"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'wo_bottom')) ? 'checked' : 'checked'; ?> required/>
                                                            </div>
                                                            <div class="col-md-11">
                                                                <select name="wo_bottom" id="wo_bottom" required>
                                                                    <option <?php if (@$editproduct->wo_bottom == '') { ?> selected="" <?php } ?> value="" selected="selected">--</option>
                                                                    <option value="XS(0-2)" <?php if (@$editproduct->wo_bottom == "XS(0-2)") { ?> selected="selected"<?php } ?> >XS(0-2)</option>
                                                                    <option value="S(2-4)" <?php if (@$editproduct->wo_bottom == "S(2-4)") { ?> selected="selected"<?php } ?> >S(2-4)</option>
                                                                    <option value="M(6-8)" <?php if (@$editproduct->wo_bottom == "M(6-8)") { ?> selected="selected"<?php } ?> >M(6-8)</option>
                                                                    <option value="L(10-12)" <?php if (@$editproduct->wo_bottom == "L(10-12)") { ?> selected="selected"<?php } ?> >L(10-12)</option>
                                                                    <option value="XL(14)" <?php if (@$editproduct->wo_bottom == "XL(14)") { ?> selected="selected"<?php } ?> >XL(14)</option>
                                                                    <option value="1X(14W-16W)" <?php if (@$editproduct->wo_bottom == "1X(14W-16W)") { ?> selected="selected"<?php } ?> >1X(14W-16W)</option>
                                                                    <option value="2X(18W-20W)" <?php if (@$editproduct->wo_bottom == "2X(18W-20W)") { ?> selected="selected"<?php } ?> >2X(18W-20W)</option>
                                                                    <option value="3X(22W-24W)" <?php if (@$editproduct->wo_bottom == "3X(22W-24W)") { ?> selected="selected"<?php } ?> >3X(22W-24W)</option>
                                                                    <option value="4X(26W-28W)" <?php if (@$editproduct->wo_bottom == "4X(26W-28W)") { ?> selected="selected"<?php } ?> >4X(26W-28W)</option>
                                                                </select>
                                                            </div>
                                                        </div>`;
                                                                }
                                                                if(data == 'paint_size' ){
                                                                    selectSizeAcc = `<div>
                                                            <label>PANTS  <sup style="color:red;">*</sup></label>
   
                                                                <input type="radio" name="primary_size" value="paint_size"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'paint_size')) ? 'checked' : 'checked'; ?> required />
                                                           
                                                            <select name="pants" id="pants" required>
                                                                <option <?php if (@$editproduct->pants == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                <optgroup label="Women's Sizes">
                                                                    <option <?php if (@$editproduct->pants == '00') { ?> selected="" <?php } ?> value="00">00</option>
                                                                    <option <?php if (@$editproduct->pants == '00') { ?> selected="" <?php } ?> value="00">00</option>
                                                                    <option <?php if (@$editproduct->pants == '0') { ?> selected="" <?php } ?> value="0">0</option>
                                                                    <option <?php if (@$editproduct->pants == '2') { ?> selected="" <?php } ?> value="2">2</option>
                                                                    <option <?php if (@$editproduct->pants == '4') { ?> selected="" <?php } ?> value="4">4</option>
                                                                    <option <?php if (@$editproduct->pants == '6') { ?> selected="" <?php } ?> value="6">6</option>
                                                                    <option <?php if (@$editproduct->pants == '8') { ?> selected="" <?php } ?> value="8">8</option>
                                                                    <option <?php if (@$editproduct->pants == '10') { ?> selected="" <?php } ?> value="10">10</option>
                                                                    <option <?php if (@$editproduct->pants == '12') { ?> selected="" <?php } ?> value="12">12</option>
                                                                    <option <?php if (@$editproduct->pants == '14') { ?> selected="" <?php } ?> value="14">14</option>
                                                                    <option <?php if (@$editproduct->pants == '16') { ?> selected="" <?php } ?> value="16">16</option>
                                                                </optgroup>
                                                                <optgroup label="Women's Plus Sizes">
                                                                    <option <?php if (@$editproduct->pants == '14W') { ?> selected="" <?php } ?> value="14W">14W</option>
                                                                    <option <?php if (@$editproduct->pants == '16W') { ?> selected="" <?php } ?> value="16W">16W</option>
                                                                    <option <?php if (@$editproduct->pants == '18W') { ?> selected="" <?php } ?> value="18W">18W</option>
                                                                    <option <?php if (@$editproduct->pants == '20W') { ?> selected="" <?php } ?> value="20W">20W</option>
                                                                    <option <?php if (@$editproduct->pants == '22W') { ?> selected="" <?php } ?> value="22W">22W</option>
                                                                    <option <?php if (@$editproduct->pants == '24W') { ?> selected="" <?php } ?> value="24W">24W</option>
                                                                </optgroup>
                                                            </select>
                                                        </div>`;
                                                                }
                                                                if(data == 'blouse_size' ){
                                                                    selectSizeAcc = `<label>SHIRT & BLOUSE <sup style="color:red;">*</sup></label>
                                                                <div class="row" >
                                                                    <div class="col-md-1">
                                                                <input type="radio" name="primary_size" value="blouse_size"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'blouse_size')) ? 'checked' : 'checked'; ?> required />
                                                            </div>
                                                        <div class="col-sm-5"  >
    
                                                            <select name="shirt_blouse" id="shirt_blouse" required>
                                                                <option <?php if (@$editproduct->shirt_blouse == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                <optgroup label="Women's Sizes">
                                                                    <option <?php if (@$editproduct->shirt_blouse == '2') { ?> selected="" <?php } ?> value="2">2</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '4') { ?> selected="" <?php } ?> value="4">4</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '6') { ?> selected="" <?php } ?> value="6">6</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '8') { ?> selected="" <?php } ?> value="8">8</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '10') { ?> selected="" <?php } ?> value="10">10</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '12') { ?> selected="" <?php } ?> value="12">12</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '14') { ?> selected="" <?php } ?> value="14">14</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '16') { ?> selected="" <?php } ?> value="16">16</option>
                                                                </optgroup>
                                                                <optgroup label="Women's Plus Sizes">
                                                                    <option <?php if (@$editproduct->shirt_blouse == '14W') { ?> selected="" <?php } ?> value="14W">14W</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '16W') { ?> selected="" <?php } ?> value="16W">16W</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '18W') { ?> selected="" <?php } ?> value="18W">18W</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '20W') { ?> selected="" <?php } ?> value="20W">20W</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '22W') { ?> selected="" <?php } ?> value="22W">22W</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '24W') { ?> selected="" <?php } ?> value="24W">24W</option>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <select name="shirt_blouse_recomend" id="shirt_blouse_recomend ">
                                                                <option <?php if (@$editproduct->shirt_blouse_recomend == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                <optgroup label="Recommended for 2" style="display: block;">
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'S (2-4)') { ?> selected="" <?php } ?> value="S (2-4)">S (2-4)</option>
                                                                </optgroup>
                                                                <optgroup label="Women's Sizes">
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'S (2-4)') { ?> selected="" <?php } ?> value="S (2-4)">S (2-4)</option>
                                                                </optgroup>
                                                                <optgroup label="Women's Sizes">
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'XXS (00)') { ?> selected="" <?php } ?> value="XXS (00)">XXS (00)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'XS (0)') { ?> selected="" <?php } ?> value="XS (0)">XS (0)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'S (2-4)') { ?> selected="" <?php } ?> value="S (2-4)">S (2-4)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'M (6-8)') { ?> selected="" <?php } ?> value="M (6-8)">M (6-8)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'L (10-12)') { ?> selected="" <?php } ?> value="L (10-12)">L (10-12)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'XL (14)') { ?> selected="" <?php } ?> value="XL (14)">XL (14)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'XXL (16)') { ?> selected="" <?php } ?> value="XXL (16)">XXL (16)</option>
                                                                </optgroup>
                                                                <optgroup label="Women's Plus Sizes">
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == '1X (14W-16W)') { ?> selected="" <?php } ?> value="1X (14W-16W)">1X (14W-16W)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == '2X (18W-20W)') { ?> selected="" <?php } ?> value="2X (18W-20W)">2X (18W-20W)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == '3X (22W-24W)') { ?> selected="" <?php } ?> value="3X (22W-24W)">3X (22W-24W)</option>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                    </div>`;
                                                                }
                                                                if(data == 'active_wr' ){
                                                                    selectSizeAcc = `<div>
                                                            <label>ACTIVE WEAR SIZE  <sup style="color:red;">*</sup></label>
                                                            <div class="col-md-1">
                                                                <input type="radio" name="primary_size" value="active_wr"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'active_wr')) ? 'checked' : 'checked'; ?> required/>
                                                            </div>
                                                            <div class="col-md-11">
                                                                <select name="active_wr" id="active_wr" required  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?> >
                                                                    <option <?php if (@$editproduct->active_wr == '') { ?> selected="" <?php } ?> value="" selected="selected">--</option>
                                                                    <option value="XXS" <?php if (@$editproduct->active_wr == "XXS") { ?> selected="selected"<?php } ?>>XXS</option>
                                                                    <option value="XS" <?php if (@$editproduct->active_wr == "XS") { ?> selected="selected"<?php } ?>>XS</option>
                                                                    <option value="S" <?php if (@$editproduct->active_wr == "S") { ?> selected="selected"<?php } ?>>S</option>
                                                                    <option value="M" <?php if (@$editproduct->active_wr == "M") { ?> selected="selected"<?php } ?>>M</option>
                                                                    <option value="L" <?php if (@$editproduct->active_wr == "L") { ?> selected="selected"<?php } ?>>L</option>
                                                                    <option value="XL" <?php if (@$editproduct->active_wr == "XL") { ?> selected="selected"<?php } ?>>XL</option>
                                                                    <option value="XXL" <?php if (@$editproduct->active_wr == "XXL") { ?> selected="selected"<?php } ?>>XXL</option>
                                                                    <option value="1X" <?php if (@$editproduct->active_wr == "1X") { ?> selected="selected"<?php } ?>>1X</option>
                                                                    <option value="2X" <?php if (@$editproduct->active_wr == "2X") { ?> selected="selected"<?php } ?>>2X</option>
                                                                    <option value="3X" <?php if (@$editproduct->active_wr == "3X") { ?> selected="selected"<?php } ?>>3X</option>
                                                                </select>
                                                            </div>
                                                        </div>`;
                                                                }
                                                                if(data == 'dress_size' ){
                                                                    selectSizeAcc = `<label>DRESS </label>
                                                    <div class="row"  >
                                                        <div class="col-md-1">
                                                            <input type="radio" name="primary_size" value="dress_size" <?= (!empty($editproduct) && ($editproduct->primary_size == 'dress_size')) ? 'checked' : 'checked'; ?> required/>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <select name="dress" id="dress" required  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?>>
                                                                <option <?php if (@$editproduct->dress == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                <optgroup label="Women's Sizes">
                                                                    <option <?php if (@$editproduct->dress == '2') { ?> selected="" <?php } ?> value="2">2</option>
                                                                    <option <?php if (@$editproduct->dress == '4') { ?> selected="" <?php } ?> value="4">4</option>
                                                                    <option <?php if (@$editproduct->dress == '6') { ?> selected="" <?php } ?> value="6">6</option>
                                                                    <option <?php if (@$editproduct->dress == '8') { ?> selected="" <?php } ?> value="8">8</option>
                                                                    <option <?php if (@$editproduct->dress == '10') { ?> selected="" <?php } ?> value="10">10</option>
                                                                    <option <?php if (@$editproduct->dress == '12') { ?> selected="" <?php } ?> value="12">12</option>
                                                                </optgroup>
                                                                <optgroup label="Women's Plus Sizes">
                                                                    <option <?php if (@$editproduct->dress == '14W') { ?> selected="" <?php } ?> value="14W">14W</option>
                                                                    <option <?php if (@$editproduct->dress == '16W') { ?> selected="" <?php } ?> value="16W">16W</option>
                                                                    <option <?php if (@$editproduct->dress == '18W') { ?> selected="" <?php } ?> value="18W">18W</option>
                                                                    <option <?php if (@$editproduct->dress == '20W') { ?> selected="" <?php } ?> value="20W">20W</option>
                                                                    <option <?php if (@$editproduct->dress == '22W') { ?> selected="" <?php } ?> value="22W">22W</option>
                                                                    <option <?php if (@$editproduct->dress == '24W') { ?> selected="" <?php } ?> value="24W">24W</option>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <select name="dress_recomended" id="dress_recomended"  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?> >
                                                                <option <?php if (@$editproduct->dress_recomended == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                <option <?php if (@$editproduct->dress_recomended == 'L (10-12)') { ?> selected="" <?php } ?> value="L (10-12)">L (10-12)</option>
                                                                <optgroup label="Women's Sizes">
                                                                    <option <?php if (@$editproduct->dress_recomended == 'XXS (00)') { ?> selected="" <?php } ?> value="XXS (00)">XXS (00)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == 'XS (0)') { ?> selected="" <?php } ?> value="XS (0)">XS (0)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == 'S (2-4)') { ?> selected="" <?php } ?> value="S (2-4)">S (2-4)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == 'M (6-8)') { ?> selected="" <?php } ?> value="M (6-8)">M (6-8)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == 'L (10-12)') { ?> selected="" <?php } ?> value="L (10-12)">L (10-12)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == 'XL (14)') { ?> selected="" <?php } ?> value="XL (14)">XL (14)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == 'XXL (16)') { ?> selected="" <?php } ?> value="XXL (16)">XXL (16)</option>
                                                                </optgroup>
                                                                <optgroup label="Women's Plus Sizes">
                                                                    <option <?php if (@$editproduct->dress_recomended == '1X (14W-16W)') { ?> selected="" <?php } ?> value="1X (14W-16W)">1X (14W-16W)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == '2X (18W-20W)') { ?> selected="" <?php } ?> value="2X (18W-20W)">2X (18W-20W)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == '3X (22W-24W)') { ?> selected="" <?php } ?> value="3X (22W-24W)">3X (22W-24W)</option>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                    </div>`;
                                                                }
                                                                if(data == 'bra_size' ){
                                                                    selectSizeAcc = `<div>
                                                            <label>BRA SIZE  <sup style="color:red;">*</sup></label> 
                                                            <div class="row">
                                                                <div class="col-md-1">
                                                                    <input type="radio" name="primary_size" value="bra_size" <?= (!empty($editproduct) && ($editproduct->primary_size == 'bra_size')) ? 'checked' : 'checked'; ?> required/>
                                                                </div>
                                                                <div class="col-sm-4">                                                                        
                                                                    <select name="bra" id="bra" required  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?>>
                                                                        <option <?php if (@$editproduct->bra == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                        <option <?php if (@$editproduct->bra == '30') { ?> selected="" <?php } ?> value="30">30</option>
                                                                        <option <?php if (@$editproduct->bra == '32') { ?> selected="" <?php } ?> value="32">32</option>
                                                                        <option <?php if (@$editproduct->bra == '34') { ?> selected="" <?php } ?> value="34">34</option>
                                                                        <option <?php if (@$editproduct->bra == '36') { ?> selected="" <?php } ?> value="36">36</option>
                                                                        <option <?php if (@$editproduct->bra == '38') { ?> selected="" <?php } ?> value="38">38</option>
                                                                        <option <?php if (@$editproduct->bra == '40') { ?> selected="" <?php } ?> value="40">40</option>
                                                                        <option <?php if (@$editproduct->bra == '42') { ?> selected="" <?php } ?> value="42">42</option>
                                                                        <option <?php if (@$editproduct->bra == '44') { ?> selected="" <?php } ?> value="44">44</option>
                                                                        <option <?php if (@$editproduct->bra == '46') { ?> selected="" <?php } ?> value="46">46</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <select name="bra_recomend" id="bra_recomend">
                                                                        <option <?php if (@$editproduct->bra_recomend == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'AA') { ?> selected="" <?php } ?> value="AA">AA</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'A') { ?> selected="" <?php } ?> value="A">A</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'B') { ?> selected="" <?php } ?> value="B">B</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'C') { ?> selected="" <?php } ?> value="C">C</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'D') { ?> selected="" <?php } ?> value="D">D</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'DD') { ?> selected="" <?php } ?> value="DD">DD</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'DDD') { ?> selected="" <?php } ?> value="DDD">DDD</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'F') { ?> selected="" <?php } ?> value="F">F</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'G') { ?> selected="" <?php } ?> value="G">G</option>
                                                                        <option <?php if (@$editproduct->bra_recomend == 'H') { ?> selected="" <?php } ?> value="H">H</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>`;
                                                                }
                                                                if(data == 'wo_jackect_size' ){
                                                                    selectSizeAcc = `<div>
                                                            <label>JACKET SIZE  <sup style="color:red;">*</sup></label>
                                                            <div class="col-md-1">
                                                                <input type="radio" name="primary_size" value="wo_jackect_size"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'wo_jackect_size')) ? 'checked' : 'checked'; ?> required />
                                                            </div>
                                                            <div class="col-md-11">
                                                                <select name="wo_jackect_size" id="wo_jackect_size" required  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?> >
                                                                    <option <?php if (@$editproduct->wo_jackect_size == '') { ?> selected="" <?php } ?> value="" selected="selected">--</option>
                                                                    <option value="XS(0-2)" <?php if (@$editproduct->wo_jackect_size == "XS(0-2)") { ?> selected="selected"<?php } ?> >XS(0-2)</option>
                                                                    <option value="S(2-4)" <?php if (@$editproduct->wo_jackect_size == "S(2-4)") { ?> selected="selected"<?php } ?> >S(2-4)</option>
                                                                    <option value="M(6-8)" <?php if (@$editproduct->wo_jackect_size == "M(6-8)") { ?> selected="selected"<?php } ?> >M(6-8)</option>
                                                                    <option value="L(10-12)" <?php if (@$editproduct->wo_jackect_size == "L(10-12)") { ?> selected="selected"<?php } ?> >L(10-12)</option>
                                                                    <option value="XL(14)" <?php if (@$editproduct->wo_jackect_size == "XL(14)") { ?> selected="selected"<?php } ?> >XL(14)</option>
                                                                    <option value="1X(14W-16W)" <?php if (@$editproduct->wo_jackect_size == "1X(14W-16W)") { ?> selected="selected"<?php } ?> >1X(14W-16W)</option>
                                                                    <option value="2X(18W-20W)" <?php if (@$editproduct->wo_jackect_size == "2X(18W-20W)") { ?> selected="selected"<?php } ?> >2X(18W-20W)</option>
                                                                    <option value="3X(22W-24W)" <?php if (@$editproduct->wo_jackect_size == "3X(22W-24W)") { ?> selected="selected"<?php } ?> >3X(22W-24W)</option>
                                                                </select>
                                                            </div>
                                                        </div>`;
                                                                }
                                                                 
                                                                $('#prd_sz_typ_div').html(selectSizeAcc);
                                                            }
                                                        </script>
                                                        <?php }else{ ?>
                                                        <label  <?= (in_array($product_sub_ctg_nme, ["A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412"]))?'style="display:none;"':''; ?>>TOP SIZE</label>
                                                    <div class="row"  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?>  <?= (in_array($product_sub_ctg_nme, ["A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412"]))?'style="display:none;"':''; ?>>
                                                        <div class="col-md-1">
                                                            <input type="radio" name="primary_size" value="top_size" <?= (!empty($editproduct) && ($editproduct->primary_size == 'top_size')) ? 'checked' : ''; ?> />
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <select name="pantsr1" id="pantsr1"  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?>>
                                                                <option <?php if (@$editproduct->pantsr1 == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                <option <?php if (@$editproduct->pantsr1 == '4') { ?> selected="" <?php } ?> value="4">4</option>
                                                                <option <?php if (@$editproduct->pantsr1 == '4.5') { ?> selected="" <?php } ?> value="4.5">4.5</option>
                                                                <option <?php if (@$editproduct->pantsr1 == '5') { ?> selected="" <?php } ?> value="5">5</option>
                                                                <option <?php if (@$editproduct->pantsr1 == '5.5') { ?> selected="" <?php } ?> value="5.5">5.5</option>
                                                                <option <?php if (@$editproduct->pantsr1 == '6') { ?> selected="" <?php } ?> value="6">6</option>
                                                                <option <?php if (@$editproduct->pantsr1 == '6.5') { ?> selected="" <?php } ?> value="6.5">6.5</option>
                                                                <option <?php if (@$editproduct->pantsr1 == '7') { ?> selected="" <?php } ?> value="7">7</option>
                                                                <option <?php if (@$editproduct->pantsr1 == '7.5') { ?> selected="" <?php } ?> value="7.5">7.5</option>
                                                                <option <?php if (@$editproduct->pantsr1 == '8') { ?> selected="" <?php } ?> value="8">8</option>
                                                                <option <?php if (@$editproduct->pantsr1 == '8.5') { ?> selected="" <?php } ?> value="8.5">8.5</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <select name="pantsr2" id="pantsr2">
                                                                <option <?php if (@$editproduct->pantsr2 == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                <option <?php if (@$editproduct->pantsr2 == 'Narrow') { ?> selected="" <?php } ?> value="Narrow">Narrow</option>
                                                                <option <?php if (@$editproduct->pantsr2 == 'Medium') { ?> selected="" <?php } ?> value="Medium">Medium</option>
                                                                <option <?php if (@$editproduct->pantsr2 == 'Wide') { ?> selected="" <?php } ?> value="Wide">Wide</option>
                                                                <option <?php if (@$editproduct->pantsr2 == 'Extra Wide') { ?> selected="" <?php } ?> value="Extra Wide">Extra Wide</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                        <?php } ?>
                                                        
                                                        <?php /* if(in_array($product_ctg_nme,[ "A7", "A8"])){ ?>                                                        
                                                        <div class="col-sm-6"   >
                                                            <label>JEANS SIZE  <sup style="color:red;">*</sup></label>
                                                            <div class="col-md-1">
                                                                <input type="radio" name="primary_size" value="jeans"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'jeans')) ? 'checked' : ''; ?> required/>
                                                            </div>
                                                            <div class="col-md-11">
                                                                <select name="jeans" id="jeans" required>
                                                                    <option <?php if (@$editproduct->jeans == '') { ?> selected="" <?php } ?> value="" selected="selected">--</option>
                                                                    <optgroup label="Women's Sizes">
                                                                        <option <?php if (@$editproduct->jeans == '00') { ?> selected="" <?php } ?> value="00">00</option>
                                                                        <option <?php if (@$editproduct->jeans == '0') { ?> selected="" <?php } ?> value="0">0</option>
                                                                        <option <?php if (@$editproduct->jeans == '2') { ?> selected="" <?php } ?> value="2">2</option>
                                                                        <option <?php if (@$editproduct->jeans == '4') { ?> selected="" <?php } ?> value="4">4</option>
                                                                        <option <?php if (@$editproduct->jeans == '6') { ?> selected="" <?php } ?> value="6">6</option>
                                                                        <option <?php if (@$editproduct->jeans == '8') { ?> selected="" <?php } ?> value="8">8</option>
                                                                        <option <?php if (@$editproduct->jeans == '10') { ?> selected="" <?php } ?> value="10">10</option>
                                                                        <option <?php if (@$editproduct->jeans == '12') { ?> selected="" <?php } ?> value="12">12</option>
                                                                        <option <?php if (@$editproduct->jeans == '14') { ?> selected="" <?php } ?> value="14">14</option>
                                                                        <option <?php if (@$editproduct->jeans == '16') { ?> selected="" <?php } ?> value="16">16</option>
                                                                    </optgroup>
                                                                    <optgroup label="Women's Plus Sizes">
                                                                        <option <?php if (@$editproduct->jeans == '14W') { ?> selected="" <?php } ?> value="14W">14W</option>
                                                                        <option <?php if (@$editproduct->jeans == '16W') { ?> selected="" <?php } ?> value="16W">16W</option>
                                                                        <option <?php if (@$editproduct->jeans == '18W') { ?> selected="" <?php } ?> value="18W">18W</option>
                                                                        <option <?php if (@$editproduct->jeans == '20W') { ?> selected="" <?php } ?> value="20W">20W</option>
                                                                        <option <?php if (@$editproduct->jeans == '22W') { ?> selected="" <?php } ?> value="22W">22W</option>
                                                                        <option <?php if (@$editproduct->jeans == '24W') { ?> selected="" <?php } ?> value="24W">24W</option>
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php }*/ ?> 
                                                        
                                                        <?php /*if(in_array($product_ctg_nme,["A4"]) || in_array($product_sub_ctg_nme, ["A41", "A42", "A47", "A46"])){ ?>
                                                        <div class="col-sm-6" >
                                                            <label>BOTTOM SIZE  <sup style="color:red;">*</sup></label>
                                                            <div class="col-md-1">
                                                                <input type="radio" name="primary_size" value="wo_bottom"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'wo_bottom')) ? 'checked' : ''; ?> required/>
                                                            </div>
                                                            <div class="col-md-11">
                                                                <select name="wo_bottom" id="wo_bottom" required  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?>>
                                                                    <option <?php if (@$editproduct->wo_bottom == '') { ?> selected="" <?php } ?> value="" selected="selected">--</option>
                                                                    <option value="XS(0-2)" <?php if (@$editproduct->wo_bottom == "XS(0-2)") { ?> selected="selected"<?php } ?> >XS(0-2)</option>
                                                                    <option value="S(2-4)" <?php if (@$editproduct->wo_bottom == "S(2-4)") { ?> selected="selected"<?php } ?> >S(2-4)</option>
                                                                    <option value="M(6-8)" <?php if (@$editproduct->wo_bottom == "M(6-8)") { ?> selected="selected"<?php } ?> >M(6-8)</option>
                                                                    <option value="L(10-12)" <?php if (@$editproduct->wo_bottom == "L(10-12)") { ?> selected="selected"<?php } ?> >L(10-12)</option>
                                                                    <option value="XL(14)" <?php if (@$editproduct->wo_bottom == "XL(14)") { ?> selected="selected"<?php } ?> >XL(14)</option>
                                                                    <option value="1X(14W-16W)" <?php if (@$editproduct->wo_bottom == "1X(14W-16W)") { ?> selected="selected"<?php } ?> >1X(14W-16W)</option>
                                                                    <option value="2X(18W-20W)" <?php if (@$editproduct->wo_bottom == "2X(18W-20W)") { ?> selected="selected"<?php } ?> >2X(18W-20W)</option>
                                                                    <option value="3X(22W-24W)" <?php if (@$editproduct->wo_bottom == "3X(22W-24W)") { ?> selected="selected"<?php } ?> >3X(22W-24W)</option>
                                                                    <option value="4X(26W-28W)" <?php if (@$editproduct->wo_bottom == "4X(26W-28W)") { ?> selected="selected"<?php } ?> >4X(26W-28W)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php }*/ ?>
                                                        
                                                        
                                                        <?php/* if(in_array($product_ctg_nme,["A4"]) || in_array($product_sub_ctg_nme, ["A43", "A45", "A44", "A46"])){ ?>
                                                        <div class="col-sm-6" >
                                                            <label>ACTIVE WEAR SIZE  <sup style="color:red;">*</sup></label>
                                                            <div class="col-md-1">
                                                                <input type="radio" name="primary_size" value="active_wr"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'active_wr')) ? 'checked' : ''; ?> required/>
                                                            </div>
                                                            <div class="col-md-11">
                                                                <select name="active_wr" id="active_wr" required  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?> >
                                                                    <option <?php if (@$editproduct->active_wr == '') { ?> selected="" <?php } ?> value="" selected="selected">--</option>
                                                                    <option value="XXS" <?php if (@$editproduct->active_wr == "XXS") { ?> selected="selected"<?php } ?>>XXS</option>
                                                                    <option value="XS" <?php if (@$editproduct->active_wr == "XS") { ?> selected="selected"<?php } ?>>XS</option>
                                                                    <option value="S" <?php if (@$editproduct->active_wr == "S") { ?> selected="selected"<?php } ?>>S</option>
                                                                    <option value="M" <?php if (@$editproduct->active_wr == "M") { ?> selected="selected"<?php } ?>>M</option>
                                                                    <option value="L" <?php if (@$editproduct->active_wr == "L") { ?> selected="selected"<?php } ?>>L</option>
                                                                    <option value="XL" <?php if (@$editproduct->active_wr == "XL") { ?> selected="selected"<?php } ?>>XL</option>
                                                                    <option value="XXL" <?php if (@$editproduct->active_wr == "XXL") { ?> selected="selected"<?php } ?>>XXL</option>
                                                                    <option value="1X" <?php if (@$editproduct->active_wr == "1X") { ?> selected="selected"<?php } ?>>1X</option>
                                                                    <option value="2X" <?php if (@$editproduct->active_wr == "2X") { ?> selected="selected"<?php } ?>>2X</option>
                                                                    <option value="3X" <?php if (@$editproduct->active_wr == "3X") { ?> selected="selected"<?php } ?>>3X</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php }*/ ?>

                                                        <?php /*if(in_array($product_ctg_nme,["A4"]) || in_array($product_sub_ctg_nme, ["A46"])){ ?>
                                                        <div class="col-sm-6"  >
                                                            <label>JACKET SIZE  <sup style="color:red;">*</sup></label>
                                                            <div class="col-md-1">
                                                                <input type="radio" name="primary_size" value="wo_jackect_size"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'wo_jackect_size')) ? 'checked' : ''; ?> required />
                                                            </div>
                                                            <div class="col-md-11">
                                                                <select name="wo_jackect_size" id="wo_jackect_size" required  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?> >
                                                                    <option <?php if (@$editproduct->wo_jackect_size == '') { ?> selected="" <?php } ?> value="" selected="selected">--</option>
                                                                    <option value="XS(0-2)" <?php if (@$editproduct->wo_jackect_size == "XS(0-2)") { ?> selected="selected"<?php } ?> >XS(0-2)</option>
                                                                    <option value="S(2-4)" <?php if (@$editproduct->wo_jackect_size == "S(2-4)") { ?> selected="selected"<?php } ?> >S(2-4)</option>
                                                                    <option value="M(6-8)" <?php if (@$editproduct->wo_jackect_size == "M(6-8)") { ?> selected="selected"<?php } ?> >M(6-8)</option>
                                                                    <option value="L(10-12)" <?php if (@$editproduct->wo_jackect_size == "L(10-12)") { ?> selected="selected"<?php } ?> >L(10-12)</option>
                                                                    <option value="XL(14)" <?php if (@$editproduct->wo_jackect_size == "XL(14)") { ?> selected="selected"<?php } ?> >XL(14)</option>
                                                                    <option value="1X(14W-16W)" <?php if (@$editproduct->wo_jackect_size == "1X(14W-16W)") { ?> selected="selected"<?php } ?> >1X(14W-16W)</option>
                                                                    <option value="2X(18W-20W)" <?php if (@$editproduct->wo_jackect_size == "2X(18W-20W)") { ?> selected="selected"<?php } ?> >2X(18W-20W)</option>
                                                                    <option value="3X(22W-24W)" <?php if (@$editproduct->wo_jackect_size == "3X(22W-24W)") { ?> selected="selected"<?php } ?> >3X(22W-24W)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php }*/ ?>
                                                        
                                                        

                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <?php if(in_array($product_ctg_nme,["A2", "A3"])){ ?>
                                                    <label>DRESS  <sup style="color:red;">*</sup></label>
                                                    <div class="row"  >
                                                        <div class="col-md-1">
                                                            <input type="radio" name="primary_size" value="dress_size" <?= (!empty($editproduct) && ($editproduct->primary_size == 'dress_size')) ? 'checked' : ''; ?> required/>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <select name="dress" id="dress" required  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?>>
                                                                <option <?php if (@$editproduct->dress == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                <optgroup label="Women's Sizes">
                                                                    <option <?php if (@$editproduct->dress == '2') { ?> selected="" <?php } ?> value="2">2</option>
                                                                    <option <?php if (@$editproduct->dress == '4') { ?> selected="" <?php } ?> value="4">4</option>
                                                                    <option <?php if (@$editproduct->dress == '6') { ?> selected="" <?php } ?> value="6">6</option>
                                                                    <option <?php if (@$editproduct->dress == '8') { ?> selected="" <?php } ?> value="8">8</option>
                                                                    <option <?php if (@$editproduct->dress == '10') { ?> selected="" <?php } ?> value="10">10</option>
                                                                    <option <?php if (@$editproduct->dress == '12') { ?> selected="" <?php } ?> value="12">12</option>
                                                                </optgroup>
                                                                <optgroup label="Women's Plus Sizes">
                                                                    <option <?php if (@$editproduct->dress == '14W') { ?> selected="" <?php } ?> value="14W">14W</option>
                                                                    <option <?php if (@$editproduct->dress == '16W') { ?> selected="" <?php } ?> value="16W">16W</option>
                                                                    <option <?php if (@$editproduct->dress == '18W') { ?> selected="" <?php } ?> value="18W">18W</option>
                                                                    <option <?php if (@$editproduct->dress == '20W') { ?> selected="" <?php } ?> value="20W">20W</option>
                                                                    <option <?php if (@$editproduct->dress == '22W') { ?> selected="" <?php } ?> value="22W">22W</option>
                                                                    <option <?php if (@$editproduct->dress == '24W') { ?> selected="" <?php } ?> value="24W">24W</option>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <select name="dress_recomended" id="dress_recomended"  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?> >
                                                                <option <?php if (@$editproduct->dress_recomended == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                <option <?php if (@$editproduct->dress_recomended == 'L (10-12)') { ?> selected="" <?php } ?> value="L (10-12)">L (10-12)</option>
                                                                <optgroup label="Women's Sizes">
                                                                    <option <?php if (@$editproduct->dress_recomended == 'XXS (00)') { ?> selected="" <?php } ?> value="XXS (00)">XXS (00)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == 'XS (0)') { ?> selected="" <?php } ?> value="XS (0)">XS (0)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == 'S (2-4)') { ?> selected="" <?php } ?> value="S (2-4)">S (2-4)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == 'M (6-8)') { ?> selected="" <?php } ?> value="M (6-8)">M (6-8)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == 'L (10-12)') { ?> selected="" <?php } ?> value="L (10-12)">L (10-12)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == 'XL (14)') { ?> selected="" <?php } ?> value="XL (14)">XL (14)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == 'XXL (16)') { ?> selected="" <?php } ?> value="XXL (16)">XXL (16)</option>
                                                                </optgroup>
                                                                <optgroup label="Women's Plus Sizes">
                                                                    <option <?php if (@$editproduct->dress_recomended == '1X (14W-16W)') { ?> selected="" <?php } ?> value="1X (14W-16W)">1X (14W-16W)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == '2X (18W-20W)') { ?> selected="" <?php } ?> value="2X (18W-20W)">2X (18W-20W)</option>
                                                                    <option <?php if (@$editproduct->dress_recomended == '3X (22W-24W)') { ?> selected="" <?php } ?> value="3X (22W-24W)">3X (22W-24W)</option>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    
                                                    <?php if(in_array($product_ctg_nme,["A1", "A9", "A11", "A12", "A14"])/* || in_array($product_sub_ctg_nme, ["A43", "A45", "A44", "A46", "A1411"])*/ ){ ?>
                                                    <label      <?= (in_array($product_sub_ctg_nme, ["A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412"]))?'style="display:none;"':''; ?>>SHIRT & BLOUSE  <sup style="color:red;">*</sup></label>
                                                    <div class="row"   <?= (in_array($product_sub_ctg_nme, ["A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412"]))?'style="display:none;"':''; ?>>

                                                        <div class="col-md-1">
                                                            <input type="radio" name="primary_size" value="blouse_size"  <?= (!empty($editproduct) && ($editproduct->primary_size == 'blouse_size')) ? 'checked' : ''; ?>  />
                                                        </div>
                                                        <div class="col-sm-4"  >
                                                            <select name="shirt_blouse" id="shirt_blouse"  <?= (in_array($product_sub_ctg_nme, ["A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412"]))?'':'required'; ?>  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?>>
                                                                <option <?php if (@$editproduct->shirt_blouse == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                <optgroup label="Women's Sizes">
                                                                    <option <?php if (@$editproduct->shirt_blouse == '2') { ?> selected="" <?php } ?> value="2">2</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '4') { ?> selected="" <?php } ?> value="4">4</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '6') { ?> selected="" <?php } ?> value="6">6</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '8') { ?> selected="" <?php } ?> value="8">8</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '10') { ?> selected="" <?php } ?> value="10">10</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '12') { ?> selected="" <?php } ?> value="12">12</option>
                                                                </optgroup>
                                                                <optgroup label="Women's Plus Sizes">
                                                                    <option <?php if (@$editproduct->shirt_blouse == '14W') { ?> selected="" <?php } ?> value="14W">14W</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '16W') { ?> selected="" <?php } ?> value="16W">16W</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '18W') { ?> selected="" <?php } ?> value="18W">18W</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '20W') { ?> selected="" <?php } ?> value="20W">20W</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '22W') { ?> selected="" <?php } ?> value="22W">22W</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse == '24W') { ?> selected="" <?php } ?> value="24W">24W</option>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <select name="shirt_blouse_recomend" id="shirt_blouse_recomend ">
                                                                <option <?php if (@$editproduct->shirt_blouse_recomend == '') { ?> selected="" <?php } ?> value="">--</option>
                                                                <optgroup label="Recommended for 2" style="display: block;">
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'S (2-4)') { ?> selected="" <?php } ?> value="S (2-4)">S (2-4)</option>
                                                                </optgroup>
                                                                <optgroup label="Women's Sizes">
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'S (2-4)') { ?> selected="" <?php } ?> value="S (2-4)">S (2-4)</option>
                                                                </optgroup>
                                                                <optgroup label="Women's Sizes">
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'XXS (00)') { ?> selected="" <?php } ?> value="XXS (00)">XXS (00)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'XS (0)') { ?> selected="" <?php } ?> value="XS (0)">XS (0)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'S (2-4)') { ?> selected="" <?php } ?> value="S (2-4)">S (2-4)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'M (6-8)') { ?> selected="" <?php } ?> value="M (6-8)">M (6-8)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'L (10-12)') { ?> selected="" <?php } ?> value="L (10-12)">L (10-12)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'XL (14)') { ?> selected="" <?php } ?> value="XL (14)">XL (14)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == 'XXL (16)') { ?> selected="" <?php } ?> value="XXL (16)">XXL (16)</option>
                                                                </optgroup>
                                                                <optgroup label="Women's Plus Sizes">
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == '1X (14W-16W)') { ?> selected="" <?php } ?> value="1X (14W-16W)">1X (14W-16W)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == '2X (18W-20W)') { ?> selected="" <?php } ?> value="2X (18W-20W)">2X (18W-20W)</option>
                                                                    <option <?php if (@$editproduct->shirt_blouse_recomend == '3X (22W-24W)') { ?> selected="" <?php } ?> value="3X (22W-24W)">3X (22W-24W)</option>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    
                                                    
                                                </div>
                                            </div>                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                         <?php if(in_array($product_ctg_nme,["G1"])){ ?>
                                        <div class="form-group"  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?>>
                                            <div class="row"  <?=(!empty($editproduct))?'style="pointer-events: none;" readonly':'' ;?>>
                                                <div class="col-md-1">
                                                    <label for="wshoe_size"> &nbsp;&nbsp;&nbsp; </label>
                                                    <input type="radio" name="primary_size" value="wshoe_size" <?= (!empty($editproduct) && ($editproduct->primary_size == 'wshoe_size')) ? 'checked' : ''; ?> />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="shoe_size"> What is your shoe size? <sup style="color:red;">*</sup></label>
                                                    <select name="shoe_size" id="shoe_size" required >
                                                        <option <?php if (@$editproduct->shoe_size == '') { ?> selected="" <?php } ?> value="" selected disabled>--</option>
                                                        <?php for ($si = 4; $si <= 13; $si = $si + 0.5) { ?><option <?php if (@$editproduct->shoe_size == $si) { ?> selected="" <?php } ?> value="<?= $si; ?>"><?= $si; ?></option>
    <?php } ?>

                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Which heel height do you prefer? <sup style="color:red;">*</sup></label>
                                                        <select name="womenHeelHightPrefer" id="womenHeelHightPrefer" aria-required="true" class="form-control" aria-invalid="false" required>
                                                            <option <?php if (@$editproduct->womenHeelHightPrefer == '') { ?> selected="" <?php } ?> value="" selected disabled>--</option>
                                                            <option <?php if (@$editproduct->womenHeelHightPrefer == 'Flat(Under 1")') { ?> selected="" <?php } ?> value='Flat(Under 1")'>Flat(Under 1")</option>
                                                            <option <?php if (@$editproduct->womenHeelHightPrefer == 'Mid(2"-3")') { ?> selected="" <?php } ?> value='Mid(2"-3")'>Mid(2"-3")</option>
                                                            <option <?php if (@$editproduct->womenHeelHightPrefer == 'High(3"-4")') { ?> selected="" <?php } ?> value='High(3"-4")'>High(3"-4")</option>
                                                            <option <?php if (@$editproduct->womenHeelHightPrefer == 'Low(1"-2")') { ?> selected="" <?php } ?> value='Low(1"-2")'>Low(1"-2")</option>
                                                            <option <?php if (@$editproduct->womenHeelHightPrefer == 'Ultra High(4.5"+)') { ?> selected="" <?php } ?> value='Ultra High(4.5"+)'>Ultra High(4.5"+)</option>
                                                        </select>                                            

                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="exampleInputPassword1"> Which style of shoes ? <sup style="color:red;">*</sup></label>
                                                    <select name="shoe_size_run" class="form-control" aria-invalid="false" required>
                                                        <option <?php if (@$editproduct->shoe_size_run == '') { ?> selected="" <?php } ?> value="" selected disabled>--</option>
                                                        <option <?php if (@$editproduct->shoe_size_run == 'Pumps') { ?> selected="" <?php } ?> value="Pumps">Pumps</option>
                                                        <option <?php if (@$editproduct->shoe_size_run == 'Sandals') { ?> selected="" <?php } ?> value="Sandals">Sandals</option>
                                                        <option <?php if (@$editproduct->shoe_size_run == 'Loafers & Flats') { ?> selected="" <?php } ?> value="Loafers & Flats">Loafers & Flats</option>
                                                        <option <?php if (@$editproduct->shoe_size_run == 'Wedges') { ?> selected="" <?php } ?> value="Wedges">Wedges</option>
                                                        <option <?php if (@$editproduct->shoe_size_run == 'Clogs & Mules') { ?> selected="" <?php } ?> value="Clogs & Mules">Clogs & Mules</option>
                                                        <option <?php if (@$editproduct->shoe_size_run == 'Sneakers') { ?> selected="" <?php } ?> value="Sneakers">Sneakers</option>
                                                        <option <?php if (@$editproduct->shoe_size_run == 'Boots & Booties') { ?> selected="" <?php } ?> value="Boots & Booties">Boots & Booties</option>
                                                        <option <?php if (@$editproduct->shoe_size_run == 'Platforms') { ?> selected="" <?php } ?> value="Platforms">Platforms</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>



                                </div>

                                <div class="row">
                                    <?php if(in_array($product_ctg_nme,["A1", "A2", "A3", "A4", "A5", "A6", "A9", "A10", "A11", "A12"]) /*|| in_array($product_sub_ctg_nme, ["A41", "A42", "A47", "A43", "A45", "A44"])*/){ ?>
                                    <div class="col-md-6"    >
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Style Inspiration   <?php if($product_ctg_nme != "A4"){ ?> <sup style="color:red;">*</sup> <?php } ?></label>
                                            <select name="wo_style_insp[]" id="wo_style_insp" class="form-control select2_select" multiple  <?php if($product_ctg_nme != "A4"){ ?> required <?php } ?>>
                                                <!--<option <?php if (@$editproduct->wo_style_insp == 'NULL') { ?> selected="" <?php } ?> value="NULL">--</option>-->
                                                <option <?php if (!empty($editproduct->wo_style_insp) && in_array('NULL', json_decode($editproduct->wo_style_insp, true))) { ?> selected <?php } ?> value=""  disabled>--</option>
                                                <option <?php if (!empty($editproduct->wo_style_insp) && in_array(1, json_decode($editproduct->wo_style_insp, true))) { ?> selected <?php } ?> value="1">Bohemian</option>
                                                <option <?php if (!empty($editproduct->wo_style_insp) && in_array(2, json_decode($editproduct->wo_style_insp, true))) { ?> selected <?php } ?> value="2">Casual</option>
                                                <option <?php if (!empty($editproduct->wo_style_insp) && in_array(3, json_decode($editproduct->wo_style_insp, true))) { ?> selected <?php } ?> value="3">Classic</option>
                                                <option <?php if (!empty($editproduct->wo_style_insp) && in_array(4, json_decode($editproduct->wo_style_insp, true))) { ?> selected <?php } ?> value="4">Edgy</option>
                                                <option <?php if (!empty($editproduct->wo_style_insp) && in_array(5, json_decode($editproduct->wo_style_insp, true))) { ?> selected <?php } ?> value="5">Trendy</option>

                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                    <?php // if(in_array($product_ctg_nme,["A2", "A6"/*, "A9", "A10", "A11", "A12"*/])){ ?>
                                    <div class="col-md-6"  >
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Dress length  <?php if(in_array($product_ctg_nme,["A2", "A6"])){ ?><sup style="color:red;">*</sup><?php } ?></label>
                                            <select name="wo_dress_length" id="wo_dress_length"  <?php if(in_array($product_ctg_nme,["A2", "A6"])){ ?>required<?php } ?>>
                                                <option <?php if (@$editproduct->wo_dress_length == 'NULL') { ?> selected="" <?php } ?> value="" selected disabled>-</option>
                                                <!--<option <?php if (@$editproduct->wo_dress_length == 'NULL') { ?> selected="" <?php } ?> value="NULL">--</option>-->
                                                <option <?php if (@$editproduct->wo_dress_length == '1') { ?> selected="" <?php } ?> value="1">Mini</option>
                                                <option <?php if (@$editproduct->wo_dress_length == '2') { ?> selected="" <?php } ?> value="2">Short</option>
                                                <option <?php if (@$editproduct->wo_dress_length == '3') { ?> selected="" <?php } ?> value="3">Midi</option>
                                                <option <?php if (@$editproduct->wo_dress_length == '4') { ?> selected="" <?php } ?> value="4">Maxi</option>

                                            </select>                                         
                                        </div>
                                    </div>
                                    <?php // } ?>
                                </div>

                                <div class="row">
                                    <?php if(in_array($product_ctg_nme,["A1", "A3", "A4", "A9", "A10", "A11", "A12", "A14"]) /*|| in_array($product_sub_ctg_nme, ["A43", "A45", "A44", "A1411"])*/){ ?>
                                    <div class="col-md-6"     <?= (in_array($product_sub_ctg_nme, ["A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412"]))?'style="display:none;"':''; ?> >
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Top half   <?php if($product_ctg_nme != "A4"){ ?> <sup style="color:red;">*</sup> <?php } ?> </label>
                                            <select name="wo_top_half[]"  id="wo_top_half" class="form-control select2_select" multiple  <?php if($product_ctg_nme != "A4"){ ?>  <?= (in_array($product_sub_ctg_nme, ["A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412"]))?'':'required'; ?> <?php } ?> >
                                                <option <?php if (!empty($editproduct->wo_top_half) && in_array('NULL', json_decode($editproduct->wo_top_half, true))) { ?> selected <?php } ?> value=""   disabled>--</option>
                                                <option <?php if (!empty($editproduct->wo_top_half) && in_array(1, json_decode($editproduct->wo_top_half, true))) { ?> selected <?php } ?> value="1">Fitted</option>
                                                <option <?php if (!empty($editproduct->wo_top_half) && in_array(2, json_decode($editproduct->wo_top_half, true))) { ?> selected <?php } ?> value="2">Straight</option>
                                                <option <?php if (!empty($editproduct->wo_top_half) && in_array(3, json_decode($editproduct->wo_top_half, true))) { ?> selected <?php } ?> value="3">Loose</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                    <?php if(in_array($product_ctg_nme,["A3", "A4", "A7", "A8"]) /*|| in_array($product_sub_ctg_nme, ["A41", "A42", "A47"])*/){ ?>
                                    <div class="col-md-6" >
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Pant Length   <?php if($product_ctg_nme != "A4"){ ?> <sup style="color:red;">*</sup> <?php } ?> </label>
                                            <select name="wo_pant_length"  <?php if($product_ctg_nme != "A4"){ ?> required <?php } ?>>
                                                <!--<option <?php if (@$editproduct->wo_pant_length == 'NULL') { ?> selected="" <?php } ?> value="NULL">--</option>-->
                                                <option <?php if (@$editproduct->wo_pant_length == 'NULL') { ?> selected="" <?php } ?> value="" selected disabled>--</option>
                                                <option <?php if (@$editproduct->wo_pant_length == '1') { ?> selected="" <?php } ?> value="1">Ankle</option>
                                                <option <?php if (@$editproduct->wo_pant_length == '2') { ?> selected="" <?php } ?> value="2">Regular</option>
                                                <option <?php if (@$editproduct->wo_pant_length == '3') { ?> selected="" <?php } ?> value="3">Long</option>

                                            </select>                                         
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                                <div class="row">
                                    <?php if(in_array($product_ctg_nme,[/*"A3",*/ "A4", "A5", "A7", "A8"]) /*|| in_array($product_sub_ctg_nme, ["A41", "A42", "A47"])*/){ ?>
                                    <div class="col-md-6" >
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Pant Rise   <?php if($product_ctg_nme != "A4"){ ?> <sup style="color:red;">*</sup> <?php } ?>  </label>
                                            <select name="wo_pant_rise" class="form-control"  <?php if($product_ctg_nme != "A4"){ ?> required <?php } ?> >
                                                <option <?php if (@$editproduct->wo_pant_rise == 'NULL') { ?> selected="" <?php } ?> value=""  selected disabled>--</option>
                                                <option <?php if (@$editproduct->wo_pant_rise == '1') { ?> selected="" <?php } ?> value="1">Low Rise</option>
                                                <option <?php if (@$editproduct->wo_pant_rise == '2') { ?> selected="" <?php } ?> value="2">Mid Raise</option>
                                                <option <?php if (@$editproduct->wo_pant_rise == '3') { ?> selected="" <?php } ?> value="3">High Raise</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                    <?php if(in_array($product_ctg_nme,["A3", "A4", "A7", "A8"])/* || in_array($product_sub_ctg_nme, ["A41", "A42", "A47"])*/){ ?>
                                    <div class="col-md-6" >
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Pant Style   <?php if($product_ctg_nme != "A4"){ ?> <sup style="color:red;">*</sup> <?php } ?> </label>
                                            <select name="wo_pant_style"  <?php if($product_ctg_nme != "A4"){ ?> required <?php } ?> >
                                                <!--<option <?php if (@$editproduct->wo_pant_style == 'NULL') { ?> selected="" <?php } ?> value="NULL">--</option>-->
                                                <option <?php if (@$editproduct->wo_pant_style == 'NULL') { ?> selected="" <?php } ?> value="" selected disabled>--</option>
                                                <option <?php if (@$editproduct->wo_pant_style == '1') { ?> selected="" <?php } ?> value="1">Skinny</option>
                                                <option <?php if (@$editproduct->wo_pant_style == '2') { ?> selected="" <?php } ?> value="2">Straight</option>
                                                <option <?php if (@$editproduct->wo_pant_style == '3') { ?> selected="" <?php } ?> value="3">Bootcut</option>
                                                <option <?php if (@$editproduct->wo_pant_style == '4') { ?> selected="" <?php } ?> value="4">Relaxed</option>
                                                <option <?php if (@$editproduct->wo_pant_style == '5') { ?> selected="" <?php } ?> value="5">Wide Leg</option>

                                            </select>                                         
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                                <div class="row">
                                    <?php if(in_array($product_ctg_nme,["A1", "A2", "A3", "A4", "A5", "A6", "A7", "A8", "A9", "A10", "A11", "A12", "A14"]) || in_array($product_sub_ctg_nme, ["A41", "A42", "A47", "A43", "A45", "A44", "A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412", "A1411"])){ ?>
                                    <div class="col-md-6" <?= (in_array($product_sub_ctg_nme, ["A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412"]))?'style="display:none;"':''; ?> >
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Appare type   <?php if($product_ctg_nme != "A4"){ ?> <sup style="color:red;">*</sup> <?php } ?> </label>
                                            <select name="wo_appare" class="form-control"  <?php if($product_ctg_nme != "A4"){ ?>   <?= (in_array($product_sub_ctg_nme, ["A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412"]))?'':'required'; ?> <?php } ?> >
                                                <option value="" selected="" <?php if (@$editproduct->wo_appare == 'NULL') { ?> selected="" <?php } ?> disabled>-</option>
                                                <!--<option <?php if (@$editproduct->wo_appare == 'NULL') { ?> selected="" <?php } ?> value="NULL">--</option>-->
                                                <option <?php if (@$editproduct->wo_appare == '1') { ?> selected="" <?php } ?> value="1">Dresses / jumpsuits</option>
                                                <option <?php if (@$editproduct->wo_appare == '2') { ?> selected="" <?php } ?> value="2">Tops</option>
                                                <option <?php if (@$editproduct->wo_appare == '3') { ?> selected="" <?php } ?> value="3">Bottoms</option>
                                                <option <?php if (@$editproduct->wo_appare == '4') { ?> selected="" <?php } ?> value="4">Denim</option>
                                                <option <?php if (@$editproduct->wo_appare == '5') { ?> selected="" <?php } ?> value="5">Sweaters</option>
                                                <option <?php if (@$editproduct->wo_appare == '6') { ?> selected="" <?php } ?> value="6">Jackets</option>
                                                <option <?php if (@$editproduct->wo_appare == '7') { ?> selected="" <?php } ?> value="7">Accessories</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                    <?php if(in_array($product_ctg_nme,["A4", "A5", "A6", "A7", "A8"]) /*|| in_array($product_sub_ctg_nme, ["A41", "A42", "A47"])*/){ ?>
                                    <div class="col-md-6"   >
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Bottoms type   <?php if($product_ctg_nme != "A4"){ ?> <sup style="color:red;">*</sup> <?php } ?> </label>
                                            <select name="wo_bottom_style"  <?php if($product_ctg_nme != "A4"){ ?> required <?php } ?> >
                                                <!--<option selected="" value="" disabled>-</option>-->
                                                <option <?php if (@$editproduct->wo_bottom_style == 'NULL') { ?> selected="" <?php } ?> value="" selected disabled>--</option>
                                                <?php if(in_array($product_sub_ctg_nme, [ "A74", "A75", "A76"])){ ?>
                                                 <option <?php if (@$editproduct->wo_bottom_style == "n/a") { ?> selected <?php } ?> value="n/a">N/A</option>
                                                 <?php } ?>
                                                <option <?php if (@$editproduct->wo_bottom_style == '1') { ?> selected="" <?php } ?> value="1">Skirts</option>
                                                <option <?php if (@$editproduct->wo_bottom_style == '2') { ?> selected="" <?php } ?> value="2">Striped Shorts</option>
                                                <option <?php if (@$editproduct->wo_bottom_style == '3') { ?> selected="" <?php } ?> value="3">Capri Jeans</option>
                                                <option <?php if (@$editproduct->wo_bottom_style == '4') { ?> selected="" <?php } ?> value="4">Cargo Pant</option>
                                                <option <?php if (@$editproduct->wo_bottom_style == '5') { ?> selected="" <?php } ?> value="5">Checked Pant</option>
                                                <option <?php if (@$editproduct->wo_bottom_style == '6') { ?> selected="" <?php } ?> value="6">Palazzo</option>
                                                <option <?php if (@$editproduct->wo_bottom_style == '7') { ?> selected="" <?php } ?> value="7">Denim Shorts</option>
                                                <option <?php if (@$editproduct->wo_bottom_style == '8') { ?> selected="" <?php } ?> value="8">Jeans</option>
                                                <option <?php if (@$editproduct->wo_bottom_style == '9') { ?> selected="" <?php } ?> value="9">Pant</option>
                                                <option <?php if (@$editproduct->wo_bottom_style == '10') { ?> selected="" <?php } ?> value="10">Shorts</option>
                                           

                                            </select>                                         
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                                <div class="row">
                                    <?php if(in_array($product_ctg_nme,["A1", "A3", "A4", "A9", "A10", "A11", "A12", "A14"]) /*|| in_array($product_sub_ctg_nme, ["A43", "A45", "A44", "A1411"])*/){ ?>
                                    <div class="col-md-6"     <?= (in_array($product_sub_ctg_nme, ["A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412"]))?'style="display:none;"':''; ?>>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Top type  <?php if($product_ctg_nme != "A4"){ ?> <sup style="color:red;">*</sup> <?php } ?>  </label>
                                            <select name="wo_top_style" class="form-control"  <?php if($product_ctg_nme != "A4"){ ?>  <?= (in_array($product_sub_ctg_nme, ["A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412"]))?'':'required'; ?> <?php } ?> >  
                                                <option value="" selected=""  <?php if (@$editproduct->wo_top_style == 'NULL') { ?> selected="" <?php } ?>   disabled>-</option>
                                                <!--<option <?php if (@$editproduct->wo_top_style == 'NULL') { ?> selected="" <?php } ?> value="NULL" disabled>--</option>-->
                                                <option <?php if (@$editproduct->wo_top_style == '1') { ?> selected="" <?php } ?> value="1">Sleevelss</option>
                                                <option <?php if (@$editproduct->wo_top_style == '2') { ?> selected="" <?php } ?> value="2">Shorts Sleeve</option>
                                                <option <?php if (@$editproduct->wo_top_style == '3') { ?> selected="" <?php } ?> value="3">Long Sleeve</option> 
                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="col-md-6"  <?= (in_array($product_sub_ctg_nme, ["A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412"]))?'style="display:none;"':''; ?>>
                                        <div class="form-group">
                                            <!--- need to check if user not picked --->
                                            <label for="exampleInputPassword1">Patterns type</label>
                                            <select name="wo_patterns" >
                                                <option <?php if (@$editproduct->wo_patterns == 'NULL') { ?> selected="" <?php } ?> value="" selected required>--</option>
                                                <option <?php if (@$editproduct->wo_patterns == '1') { ?> selected="" <?php } ?> value="1">Lace</option>
                                                <option <?php if (@$editproduct->wo_patterns == '2') { ?> selected="" <?php } ?> value="2">Animal Print</option>
                                                <option <?php if (@$editproduct->wo_patterns == '3') { ?> selected="" <?php } ?> value="3">Tribal</option>
                                                <option <?php if (@$editproduct->wo_patterns == '4') { ?> selected="" <?php } ?> value="4">Polak Dot</option>
                                                <option <?php if (@$editproduct->wo_patterns == '5') { ?> selected="" <?php } ?> value="5">Stripes</option>
                                                <option <?php if (@$editproduct->wo_patterns == '6') { ?> selected="" <?php } ?> value="6">Floral</option>

                                            </select>                                         
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <?php if(in_array($product_ctg_nme,["A7"])){ ?>
                                    <div class="col-md-6" >
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Denim styles?   <?php if($product_ctg_nme != "A4"){ ?> <sup style="color:red;">*</sup> <?php } ?> </label>
                                            <select name="denim_styles[]" id="denim_styles" class="form-control select2_select" multiple  <?php if($product_ctg_nme != "A4"){ ?> required <?php } ?> >
                                                <option <?php if (!empty($editproduct->denim_styles) && in_array('NULL', json_decode($editproduct->denim_styles, true))) { ?> selected <?php } ?> value="" disabled>--</option>
                                                <option <?php if (!empty($editproduct->denim_styles) && in_array('distressed_denim_non', json_decode($editproduct->denim_styles, true))) { ?> selected <?php } ?> value="distressed_denim_non">Distressed denim non</option>
                                                <option <?php if (!empty($editproduct->denim_styles) && in_array('distressed_denim_minimally', json_decode($editproduct->denim_styles, true))) { ?> selected <?php } ?> value="distressed_denim_minimally">Distressed denim minimally</option>
                                                <option <?php if (!empty($editproduct->denim_styles) && in_array('distressed_denim_fairly', json_decode($editproduct->denim_styles, true))) { ?> selected <?php } ?> value="distressed_denim_fairly">Distressed denim fairly</option>
                                                <option <?php if (!empty($editproduct->denim_styles) && in_array('distressed_denim_heavily', json_decode($editproduct->denim_styles, true))) { ?> selected <?php } ?> value="distressed_denim_heavily">Distressed denim heavily</option>

                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Missing from fit/your closet?</label>
                                            <select name="missing_from_your_fIT" class="form-control">
                                                <option <?php if (@$editproduct->missing_from_your_fIT == 'NULL') { ?> selected="" <?php } ?> value="" disabled selected>--</option>
                                                <option <?php if (@$editproduct->missing_from_your_fIT == 'Sweaters') { ?> selected="" <?php } ?> value="Sweaters">Sweaters</option>
                                                <option <?php if (@$editproduct->missing_from_your_fIT == 'Blouses') { ?> selected="" <?php } ?> value="Blouses">Blouses</option>
                                                <option <?php if (@$editproduct->missing_from_your_fIT == 'Jeans') { ?> selected="" <?php } ?> value="Jeans">Jeans</option>
                                                <option <?php if (@$editproduct->missing_from_your_fIT == 'Pants') { ?> selected="" <?php } ?> value="Pants">Pants</option>
                                                <option <?php if (@$editproduct->missing_from_your_fIT == 'Skirts') { ?> selected="" <?php } ?> value="Skirts">Skirts</option>
                                                <option <?php if (@$editproduct->missing_from_your_fIT == 'SkiDressesrts') { ?> selected="" <?php } ?> value="Dresses">Dresses</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <!--- need to check if user not picked --->
                                            <label for="exampleInputPassword1">OutFit prefer to wear</label>

                                            <div class="btn-group btn-group-toggle" id="wom_outfit_wer" data-toggle="buttons" style="float: left;width: 100%;">
                                                <label class="btn btn-secondary   <?php if (empty($editproduct->outfit_prefer)) { ?> active <?php } ?>" for="wmens12300" onclick="updateOutfitWomenChkbox()" style="float: left;width: 12.5%;height: 165px;align-items: center;display: flex;" >
                                                    <input type="checkbox" name="outfit_prefer[]" autocomplete="off" value="NULL"  <?php if (!empty($editproduct->outfit_prefer) && in_array('NULL', json_decode($editproduct->outfit_prefer, true))) { ?> checked <?php } ?> id="wmens12300"> None </label>
                                                <label class="btn btn-secondary <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v3', json_decode($editproduct->outfit_prefer, true))) { ?> active <?php } ?>" style="float: left;width: 12.5%;" onclick="$('#wom_outfit_wer label:first').removeClass('active');">
                                                    <input type="checkbox" name="outfit_prefer[]" autocomplete="off" value="style_sphere_selections_v3"  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v3', json_decode($editproduct->outfit_prefer, true))) { ?> checked <?php } ?> > 
                                                    <img src="<?= HTTP_ROOT_BASE; ?>assets/women-img/women-summeroutfit1.jpg" alt="" width="100">
                                                </label>
                                                <label class="btn btn-secondary  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v4', json_decode($editproduct->outfit_prefer, true))) { ?> active <?php } ?>" style="float: left;width: 12.5%;" onclick="$('#wom_outfit_wer label:first').removeClass('active');">
                                                    <input type="checkbox" name="outfit_prefer[]" autocomplete="off" value="style_sphere_selections_v4"  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v4', json_decode($editproduct->outfit_prefer, true))) { ?> checked <?php } ?>> 
                                                    <img src="<?= HTTP_ROOT_BASE; ?>assets/women-img/women-summeroutfit2.jpg" alt="" width="100">
                                                </label>
                                                <label class="btn btn-secondary  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v5', json_decode($editproduct->outfit_prefer, true))) { ?> active <?php } ?>" style="float: left;width: 12.5%;" onclick="$('#wom_outfit_wer label:first').removeClass('active');">
                                                    <input type="checkbox" name="outfit_prefer[]" autocomplete="off" value="style_sphere_selections_v5"  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v5', json_decode($editproduct->outfit_prefer, true))) { ?> checked <?php } ?>> 
                                                    <img src="<?= HTTP_ROOT_BASE; ?>assets/women-img/women-summeroutfit3.jpg" alt="" width="100">
                                                </label>
                                                <label class="btn btn-secondary  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v6', json_decode($editproduct->outfit_prefer, true))) { ?> active <?php } ?>" style="float: left;width: 12.5%;" onclick="$('#wom_outfit_wer label:first').removeClass('active');">
                                                    <input type="checkbox" name="outfit_prefer[]" autocomplete="off" value="style_sphere_selections_v6"  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v6', json_decode($editproduct->outfit_prefer, true))) { ?> checked <?php } ?>> 
                                                    <img src="<?= HTTP_ROOT_BASE; ?>assets/women-img/women-summeroutfit4.jpg" alt="" width="100">
                                                </label>
                                                <label class="btn btn-secondary  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v7', json_decode($editproduct->outfit_prefer, true))) { ?> active <?php } ?>" style="float: left;width: 12.5%;" onclick="$('#wom_outfit_wer label:first').removeClass('active');">
                                                    <input type="checkbox" name="outfit_prefer[]" autocomplete="off" value="style_sphere_selections_v7"  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v7', json_decode($editproduct->outfit_prefer, true))) { ?> checked <?php } ?>> 
                                                    <img src="<?= HTTP_ROOT_BASE; ?>assets/women-img/women-summeroutfit5.jpg" alt="" width="100">
                                                </label>
                                                <label class="btn btn-secondary  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v8', json_decode($editproduct->outfit_prefer, true))) { ?> active <?php } ?>" style="float: left;width: 12.5%;" onclick="$('#wom_outfit_wer label:first').removeClass('active');">
                                                    <input type="checkbox" name="outfit_prefer[]" autocomplete="off" value="style_sphere_selections_v8"  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v8', json_decode($editproduct->outfit_prefer, true))) { ?> checked <?php } ?>> 
                                                    <img src="<?= HTTP_ROOT_BASE; ?>assets/women-img/women-summeroutfit6.jpg" alt="" width="100">
                                                </label>
                                                <label class="btn btn-secondary  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v9', json_decode($editproduct->outfit_prefer, true))) { ?> active <?php } ?>" style="float: left;width: 12.5%;" onclick="$('#wom_outfit_wer label:first').removeClass('active');">
                                                    <input type="checkbox" name="outfit_prefer[]" autocomplete="off" value="style_sphere_selections_v9"  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v9', json_decode($editproduct->outfit_prefer, true))) { ?> checked <?php } ?>> 
                                                    <img src="<?= HTTP_ROOT_BASE; ?>assets/women-img/women-summeroutfit7.jpg" alt="" width="100">
                                                </label>
                                                <label class="btn btn-secondary  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v11', json_decode($editproduct->outfit_prefer, true))) { ?> active <?php } ?>" style="float: left;width: 12.5%;" onclick="$('#wom_outfit_wer label:first').removeClass('active');">
                                                    <input type="checkbox" name="outfit_prefer[]" autocomplete="off" value="style_sphere_selections_v11"  <?php if (!empty($editproduct->outfit_prefer) && in_array('style_sphere_selections_v11', json_decode($editproduct->outfit_prefer, true))) { ?> checked <?php } ?>> 
                                                    <img src="<?= HTTP_ROOT_BASE; ?>assets/women-img/women-summeroutfit8.jpg" alt="" width="100">
                                                </label>

                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4><b>Budget</b></h4>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">TOPS</label>
                                            <input type="radio" name="budget_type" value="wo_top_budg" <?php if ((@$editproduct->budget_type == "wo_top_budg")) { ?> checked <?php } ?>>
                                            <select name="wo_top_budg" class="form-control" style="width: 85%;">
                                                <option <?php if ((@$editproduct->budget_type == "wo_top_budg") && (@$editproduct->budget_value == 'NULL')) { ?> selected="NULL" <?php } ?> value="">--</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_top_budg") && (@$editproduct->budget_value == '1')) { ?> selected="" <?php } ?> value="1">Under $50</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_top_budg") && (@$editproduct->budget_value == '2')) { ?> selected="" <?php } ?> value="2">$50 - $75</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_top_budg") && (@$editproduct->budget_value == '3')) { ?> selected="" <?php } ?> value="3">$75 - $100</option> 
                                                <option <?php if ((@$editproduct->budget_type == "wo_top_budg") && (@$editproduct->budget_value == '4')) { ?> selected="" <?php } ?> value="4">$100 - $125</option> 
                                                <option <?php if ((@$editproduct->budget_type == "wo_top_budg") && (@$editproduct->budget_value == '5')) { ?> selected="" <?php } ?> value="5">$125+</option> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">BOTTOMS</label>
                                            <input type="radio" name="budget_type" value="wo_bottoms_budg" <?php if ((@$editproduct->budget_type == "wo_bottoms_budg")) { ?> checked <?php } ?>>
                                            <select name="wo_bottoms_budg" class="form-control" style="width: 85%;">
                                                <option <?php if ((@$editproduct->budget_type == "wo_bottoms_budg") && (@$editproduct->budget_value == 'NULL')) { ?> selected="NULL" <?php } ?> value="">--</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_bottoms_budg") && (@$editproduct->budget_value == '1')) { ?> selected="" <?php } ?> value="1">Under $30</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_bottoms_budg") && (@$editproduct->budget_value == '2')) { ?> selected="" <?php } ?> value="2">$30 - $50</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_bottoms_budg") && (@$editproduct->budget_value == '3')) { ?> selected="" <?php } ?> value="3">$50 - $70</option> 
                                                <option <?php if ((@$editproduct->budget_type == "wo_bottoms_budg") && (@$editproduct->budget_value == '4')) { ?> selected="" <?php } ?> value="4">$70 - $90</option> 
                                                <option <?php if ((@$editproduct->budget_type == "wo_bottoms_budg") && (@$editproduct->budget_value == '5')) { ?> selected="" <?php } ?> value="5">$90+</option> 
                                            </select>                                       
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">OUTERWEAR</label>
                                            <input type="radio" name="budget_type" value="wo_outerwear_budg"  <?php if ((@$editproduct->budget_type == "wo_outerwear_budg")) { ?> checked <?php } ?>>
                                            <select name="wo_outerwear_budg" class="form-control" style="width:85%;">
                                                <option <?php if ((@$editproduct->budget_type == "wo_outerwear_budg") && (@$editproduct->budget_value == 'NULL')) { ?> selected="NULL" <?php } ?> value="">--</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_outerwear_budg") && (@$editproduct->budget_value == '1')) { ?> selected="" <?php } ?> value="1">Under $50</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_outerwear_budg") && (@$editproduct->budget_value == '2')) { ?> selected="" <?php } ?> value="2">$50 - $75</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_outerwear_budg") && (@$editproduct->budget_value == '3')) { ?> selected="" <?php } ?> value="3">$75 - $100</option> 
                                                <option <?php if ((@$editproduct->budget_type == "wo_outerwear_budg") && (@$editproduct->budget_value == '4')) { ?> selected="" <?php } ?> value="4">$100 - $125</option> 
                                                <option <?php if ((@$editproduct->budget_type == "wo_outerwear_budg") && (@$editproduct->budget_value == '5')) { ?> selected="" <?php } ?> value="5">$125+</option> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">JEANS</label>
                                            <input type="radio" name="budget_type" value="wo_jeans_budg"  <?php if ((@$editproduct->budget_type == "wo_jeans_budg")) { ?> checked <?php } ?>>
                                            <select name="wo_jeans_budg" class="form-control"  style="width:85%;">
                                                <option <?php if ((@$editproduct->budget_type == "wo_jeans_budg") && (@$editproduct->budget_value == 'NULL')) { ?> selected="" <?php } ?> value="" selected disabled>--</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_jeans_budg") && (@$editproduct->budget_value == '1')) { ?> selected="" <?php } ?> value="1">Under $75 </option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_jeans_budg") && (@$editproduct->budget_value == '2')) { ?> selected="" <?php } ?> value="2">$75 - $100 </option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_jeans_budg") && (@$editproduct->budget_value == '3')) { ?> selected="" <?php } ?> value="3">$100 - $125 </option> 
                                                <option <?php if ((@$editproduct->budget_type == "wo_jeans_budg") && (@$editproduct->budget_value == '4')) { ?> selected="" <?php } ?> value="4">$125 - $175 </option> 
                                                <option <?php if ((@$editproduct->budget_type == "wo_jeans_budg") && (@$editproduct->budget_value == '5')) { ?> selected="" <?php } ?> value="5">$175+</option> 
                                            </select>                                       
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">JEWELRY</label>
                                            <input type="radio" name="budget_type" value="wo_jewelry_budg"  <?php if ((@$editproduct->budget_type == "wo_jewelry_budg")) { ?> checked <?php } ?>>
                                            <select name="wo_jewelry_budg" class="form-control" style="width:85%;">
                                                <option <?php if ((@$editproduct->budget_type == "wo_jewelry_budg") && (@$editproduct->budget_value == 'NULL')) { ?> selected="" <?php } ?> value="" selected disabled>--</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_jewelry_budg") && (@$editproduct->budget_value == '1')) { ?> selected="" <?php } ?> value="1">Under $40</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_jewelry_budg") && (@$editproduct->budget_value == '2')) { ?> selected="" <?php } ?> value="2">$40 - $60</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_jewelry_budg") && (@$editproduct->budget_value == '3')) { ?> selected="" <?php } ?> value="3">$60 - $80 </option> 
                                                <option <?php if ((@$editproduct->budget_type == "wo_jewelry_budg") && (@$editproduct->budget_value == '4')) { ?> selected="" <?php } ?> value="4">$80 - $100</option> 
                                                <option <?php if ((@$editproduct->budget_type == "wo_jewelry_budg") && (@$editproduct->budget_value == '5')) { ?> selected="" <?php } ?> value="5">$100+</option> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">ACCESSORIES</label>
                                            <input type="radio" name="budget_type" value="wo_accessories_budg" <?php if ((@$editproduct->budget_type == "wo_accessories_budg")) { ?> checked <?php } ?>>
                                            <select name="wo_accessories_budg" class="form-control" style="width:85%;">
                                                <option <?php if ((@$editproduct->budget_type == "wo_accessories_budg") && (@$editproduct->budget_value == 'NULL')) { ?> selected="" <?php } ?> value="" selected disabled>--</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_accessories_budg") && (@$editproduct->budget_value == '1')) { ?> selected="" <?php } ?> value="1">Under $75 </option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_accessories_budg") && (@$editproduct->budget_value == '2')) { ?> selected="" <?php } ?> value="2">$75 - $125 </option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_accessories_budg") && (@$editproduct->budget_value == '3')) { ?> selected="" <?php } ?> value="3">$125 - $175 </option> 
                                                <option <?php if ((@$editproduct->budget_type == "wo_accessories_budg") && (@$editproduct->budget_value == '4')) { ?> selected="" <?php } ?> value="4">$175 - $250 </option> 
                                                <option <?php if ((@$editproduct->budget_type == "wo_accessories_budg") && (@$editproduct->budget_value == '5')) { ?> selected="" <?php } ?> value="5">$250+</option> 
                                            </select>                                       
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">DRESS</label>
                                            <input type="radio" name="budget_type" value="wo_dress_budg"  <?php if ((@$editproduct->budget_type == "wo_dress_budg")) { ?> checked <?php } ?>>
                                            <select name="wo_dress_budg" class="form-control" style="width:85%;">
                                                <option <?php if ((@$editproduct->budget_type == "wo_dress_budg") && (@$editproduct->budget_value == 'NULL')) { ?> selected="" <?php } ?> value="" selected disabled>--</option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_dress_budg") && (@$editproduct->budget_value == '1')) { ?> selected="" <?php } ?> value="1">Under $75 </option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_dress_budg") && (@$editproduct->budget_value == '2')) { ?> selected="" <?php } ?> value="2">$75 - $125 </option>
                                                <option <?php if ((@$editproduct->budget_type == "wo_dress_budg") && (@$editproduct->budget_value == '3')) { ?> selected="" <?php } ?> value="3">$125 - $175 </option> 
                                                <option <?php if ((@$editproduct->budget_type == "wo_dress_budg") && (@$editproduct->budget_value == '4')) { ?> selected="" <?php } ?> value="4">$175 - $250 </option> 
                                                <option <?php if ((@$editproduct->budget_type == "wo_dress_budg") && (@$editproduct->budget_value == '5')) { ?> selected="" <?php } ?> value="5">$250+</option> 
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 skin">
                                        <label >Skin tone ?</label>
                                        <ul>
                                            <li>
                                                <input class="radio-box" value="1"  <?php if (!empty($editproduct->skin_tone) && in_array(1, json_decode($editproduct->skin_tone, true))) { ?> checked <?php } ?> id="radio2a" name="skin_tone[]" type="checkbox">
                                                <label for="radio2a"></label>
                                            </li>
                                            <li>
                                                <input class="radio-box" value="2"  <?php if (!empty($editproduct->skin_tone) && in_array(2, json_decode($editproduct->skin_tone, true))) { ?> checked <?php } ?>  id="radio2b" name="skin_tone[]" type="checkbox">
                                                <label for="radio2b"></label>
                                            </li>
                                            <li>
                                                <input class="radio-box" value="3" <?php if (!empty($editproduct->skin_tone) && in_array(3, json_decode($editproduct->skin_tone, true))) { ?> checked <?php } ?>  id="radio2c" name="skin_tone[]" type="checkbox">
                                                <label for="radio2c"></label>
                                            </li>
                                            <li>
                                                <input class="radio-box" value="4" <?php if (!empty($editproduct->skin_tone) && in_array(4, json_decode($editproduct->skin_tone, true))) { ?> checked <?php } ?>  id="radio2d" name="skin_tone[]" type="checkbox">
                                                <label for="radio2d"></label>
                                            </li>
                                            <li>
                                                <input class="radio-box" value="5" <?php if (!empty($editproduct->skin_tone) && in_array(5, json_decode($editproduct->skin_tone, true))) { ?> checked <?php } ?>  id="radio2e" name="skin_tone[]" type="checkbox">
                                                <label for="radio2e"></label>
                                            </li>
                                            <li>
                                                <input class="radio-box" value="6" <?php if (!empty($editproduct->skin_tone) && in_array(6, json_decode($editproduct->skin_tone, true))) { ?> checked <?php } ?>  id="radio2f" name="skin_tone[]" type="checkbox">
                                                <label for="radio2f"><span>OTHER</span></label>
                                            </li>
                                        </ul>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Shoulders?</label>
                                            <select name="proportion_shoulders" id="proportion_shoulders">
                                                <option <?php if (@$editproduct->proportion_shoulders == 'NULL') { ?> selected="" <?php } ?> value=""  selected disabled>--</option>
                                                <optgroup label="Women's Sizes">
                                                    <option <?php if (@$editproduct->proportion_shoulders == '00') { ?> selected="" <?php } ?> value="00">00</option>
                                                    <option <?php if (@$editproduct->proportion_shoulders == '0') { ?> selected="" <?php } ?> value="0">0</option>
                                                    <option <?php if (@$editproduct->proportion_shoulders == '2') { ?> selected="" <?php } ?> value="2">2</option>
                                                    <option <?php if (@$editproduct->proportion_shoulders == '4') { ?> selected="" <?php } ?> value="4">4</option>
                                                    <option <?php if (@$editproduct->proportion_shoulders == '6') { ?> selected="" <?php } ?> value="6">6</option>
                                                    <option <?php if (@$editproduct->proportion_shoulders == '8') { ?> selected="" <?php } ?> value="8">8</option>
                                                    <option <?php if (@$editproduct->proportion_shoulders == '10') { ?> selected="" <?php } ?> value="10">10</option>
                                                    <option <?php if (@$editproduct->proportion_shoulders == '12') { ?> selected="" <?php } ?> value="12">12</option>
                                                    <option <?php if (@$editproduct->proportion_shoulders == '14') { ?> selected="" <?php } ?> value="14">14</option>
                                                    <option <?php if (@$editproduct->proportion_shoulders == '16') { ?> selected="" <?php } ?> value="16">16</option>
                                                </optgroup>
                                                <optgroup label="Women's Plus Sizes">
                                                    <option <?php if (@$editproduct->proportion_shoulders == '14W') { ?> selected="" <?php } ?> value="14W">14W</option>
                                                    <option <?php if (@$editproduct->proportion_shoulders == '16W') { ?> selected="" <?php } ?> value="16W">16W</option>
                                                    <option <?php if (@$editproduct->proportion_shoulders == '18W') { ?> selected="" <?php } ?> value="18W">18W</option>
                                                    <option <?php if (@$editproduct->proportion_shoulders == '20W') { ?> selected="" <?php } ?> value="20W">20W</option>
                                                    <option <?php if (@$editproduct->proportion_shoulders == '22W') { ?> selected="" <?php } ?> value="22W">22W</option>
                                                    <option <?php if (@$editproduct->proportion_shoulders == '24W') { ?> selected="" <?php } ?> value="24W">24W</option>
                                                </optgroup>
                                            </select>                                         
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php if(in_array($product_ctg_nme,["A3", "A4", "A5", "A6", "A7", "A8"]) || in_array($product_sub_ctg_nme, ["A41", "A42", "A47"]) ){ ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Legs?   <?php if($product_ctg_nme != "A4"){ ?> <sup style="color:red;">*</sup> <?php } ?> </label>
                                            <select name="proportion_legs" id="proportion_legs"  <?php if($product_ctg_nme != "A4"){ ?> required <?php } ?>>
                                                <option <?php if (@$editproduct->proportion_legs == 'NULL') { ?> selected="" <?php } ?> value="" selected disabled>--</option>
                                                <!--<option <?php if (@$editproduct->proportion_legs == 'NULL') { ?> selected="" <?php } ?> value="NULL">--</option>-->
                                                <option <?php if (@$editproduct->proportion_legs == '30') { ?> selected="" <?php } ?> value="30">30</option>
                                                <option <?php if (@$editproduct->proportion_legs == '32') { ?> selected="" <?php } ?> value="32">32</option>
                                                <option <?php if (@$editproduct->proportion_legs == '34') { ?> selected="" <?php } ?> value="34">34</option>
                                                <option <?php if (@$editproduct->proportion_legs == '36') { ?> selected="" <?php } ?> value="36">36</option>
                                                <option <?php if (@$editproduct->proportion_legs == '38') { ?> selected="" <?php } ?> value="38">38</option>
                                                <option <?php if (@$editproduct->proportion_legs == '40') { ?> selected="" <?php } ?> value="40">40</option>
                                                <option <?php if (@$editproduct->proportion_legs == '42') { ?> selected="" <?php } ?> value="42">42</option>
                                                <option <?php if (@$editproduct->proportion_legs == '44') { ?> selected="" <?php } ?> value="44">44</option>
                                                <option <?php if (@$editproduct->proportion_legs == '46') { ?> selected="" <?php } ?> value="46">46</option>
                                            </select>                                         
                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                    <?php if(in_array($product_ctg_nme,["A1", "A2", "A3", "A4", "A9", "A10", "A11", "A12"]) || in_array($product_sub_ctg_nme, ["A43", "A45"])){ ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Arms?   <?php if($product_ctg_nme != "A4"){ ?> <sup style="color:red;">*</sup> <?php } ?> </label>
                                            <select name="proportion_arms" id="proportion_arms"  <?php if($product_ctg_nme != "A4"){ ?> required <?php } ?>>
                                                <option <?php if (@$editproduct->proportion_arms == 'NULL') { ?> selected="" <?php } ?> value="" selected disabled>-</option>
                                                <!--<option <?php if (@$editproduct->proportion_arms == 'NULL') { ?> selected="" <?php } ?> value="NULL">--</option>-->
                                                <option <?php if (@$editproduct->proportion_arms == 'XXS') { ?> selected="" <?php } ?> value="XXS">XXS</option>
                                                <option <?php if (@$editproduct->proportion_arms == 'XS') { ?> selected="" <?php } ?> value="XS">XS</option>
                                                <option <?php if (@$editproduct->proportion_arms == 'S') { ?> selected="" <?php } ?> value="S">S</option>
                                                <option <?php if (@$editproduct->proportion_arms == 'M') { ?> selected="" <?php } ?> value="M">M</option>
                                                <option <?php if (@$editproduct->proportion_arms == 'L') { ?> selected="" <?php } ?> value="L">L</option>
                                                <option <?php if (@$editproduct->proportion_arms == 'XL') { ?> selected="" <?php } ?> value="XL">XL</option>
                                                <option <?php if (@$editproduct->proportion_arms == 'XXL') { ?> selected="" <?php } ?> value="XXL">XXL</option>
                                                <option <?php if (@$editproduct->proportion_arms == '1X') { ?> selected="" <?php } ?> value="1X">1X</option>
                                                <option <?php if (@$editproduct->proportion_arms == '2X') { ?> selected="" <?php } ?> value="2X">2X</option>
                                                <option <?php if (@$editproduct->proportion_arms == '3X') { ?> selected="" <?php } ?> value="3X">3X</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Hips ?</label>
                                            <select name="proportion_hips" id="jeans">
                                                <option value="">--</option>
                                                <optgroup label="Women's Sizes"> 
                                                    <option <?php if (@$editproduct->proportion_hips == 'NULL') { ?> selected="" <?php } ?> value=""  selected disabled>--</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '00') { ?> selected="" <?php } ?> value="00">00</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '0') { ?> selected="" <?php } ?> value="0">0</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '2') { ?> selected="" <?php } ?> value="2">2</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '4') { ?> selected="" <?php } ?> value="4">4</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '6') { ?> selected="" <?php } ?> value="6">6</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '8') { ?> selected="" <?php } ?> value="8">8</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '10') { ?> selected="" <?php } ?> value="10">10</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '12') { ?> selected="" <?php } ?> value="12">12</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '14') { ?> selected="" <?php } ?> value="14">14</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '16') { ?> selected="" <?php } ?> value="16">16</option>
                                                </optgroup>
                                                <optgroup label="Women's Plus Sizes">
                                                    <option <?php if (@$editproduct->proportion_hips == '14W') { ?> selected="" <?php } ?> value="14W">14W</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '16W') { ?> selected="" <?php } ?> value="16W">16W</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '18W') { ?> selected="" <?php } ?> value="18W">18W</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '20W') { ?> selected="" <?php } ?> value="20W">20W</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '22W') { ?> selected="" <?php } ?> value="22W">22W</option>
                                                    <option <?php if (@$editproduct->proportion_hips == '24W') { ?> selected="" <?php } ?> value="24W">24W</option>
                                                </optgroup>
                                            </select>                                          
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Purchase price ? <sup style="color:red;">*</sup></label>
    <?= $this->Form->input('purchase_price', ['value' => @$editproduct->purchase_price, 'type' => 'text', 'class' => "form-control", 'label' => false, 'placeholder' => 'Please enter purchase price', 'required']); ?>                            
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">sale_price ? <sup style="color:red;">*</sup></label>
    <?= $this->Form->input('sale_price', ['value' => @$editproduct->sale_price, 'type' => 'text', 'class' => "form-control", 'label' => false, 'placeholder' => 'Please enter sale price', 'required']); ?>                            
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Clearance price</label>
    <?= $this->Form->input('clearance_price', ['value' => @$editproduct->clearance_price, 'type' => 'text', 'class' => "form-control", 'label' => false]); ?> 
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
    <?php if (empty($editproduct)) { ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Quantity ? <sup style="color:red;">*</sup></label>
        <?= $this->Form->input('quantity', ['value' => ((@$editproduct->quantity > 0) ? @$editproduct->quantity : ''), 'type' => 'number', 'class' => "form-control", 'label' => false, 'placeholder' => 'Please enter quantity', 'min' => "0", 'required']); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Available status</label>
                                                <select name="available_status" class="form-control">
                                                    <option <?php if (@$editproduct->available_status == '') { ?> selected="" <?php } ?> value="">--</option>
                                                    <option <?php if (@$editproduct->available_status == '1') { ?> selected="" <?php } ?> value="1">Available</option>                                
                                                    <option <?php if (@$editproduct->available_status == '2') { ?> selected="" <?php } ?> value="2">Not Available</option>
                                                </select>
                                            </div>
                                        </div>
    <?php } ?>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Display status</label>
                                            <select name="display_status" class="form-control">
                                                <option <?php if (@$editproduct->display_status == '') { ?> selected="" <?php } ?> value="">--</option>
                                                <option <?php if (@$editproduct->display_status == '1') { ?> selected="" <?php } ?> value="1">Display</option>                                
                                                <option <?php if (@$editproduct->display_status == '2') { ?> selected="" <?php } ?> value="2">Non Display</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Clearance status</label>
                                                <select name="is_clearance" class="form-control">
                                                    <option <?php if (@$editproduct->is_clearance == '') { ?> selected="" <?php } ?> value="">--</option>
                                                    <option <?php if (@$editproduct->is_clearance == 1) { ?> selected="" <?php } ?> value="1">Set for clearance</option>                                
                                                    <option <?php if (@$editproduct->is_clearance == 2) { ?> selected="" <?php } ?> value="2">Not set for clearance</option>
                                                </select>
                                            </div>
                                        </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Product Image <sup style="color:red;">*</sup> <span style="color:red;font-weight: 400;">20 Kb ( PNG, JPG ,JPEG)</span></label>

    <?php if (@$editproduct->product_image) { ?>
                                                <div class="form-group">                                                        
                                                    <img src="<?php echo HTTP_ROOT . PRODUCT_IMAGES; ?><?php echo @$editproduct->product_image; ?>" style="width: 50px;"/>
                                                    <p><a onclick="return confirm('Are you sure want to delete ?')" href="<?php echo HTTP_ROOT . 'appadmins/productimgdelete/Women/' . @$id ?>"><img src="<?php echo HTTP_ROOT . 'img/trash.png' ?>"/></a></p>
                                                </div>                                    
                                                <?php } else { ?>
                                                <div class="form-group">
        <?= $this->Form->input('product_image', ['type' => 'file', 'id' => 'image', 'label' => false, 'kl_virtual_keyboard_secure_input' => "on", 'required']); ?>                                        

                                                    <div class="help-block with-errors"></div>
                                                </div>
    <?php } ?>  
                                            <div id="imagePreview"></div>                           
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Note</label>
    <?= $this->Form->input('note', ['value' => @$editproduct->note, 'type' => 'textarea', 'class' => "form-control", 'label' => false, 'placeholder' => 'Please enter note']); ?>
                                        </div>
                                    </div>
                                </div>
    

                                <?php
                                if ($editproduct->is_deleted == 1) {
                                    echo "<h1 style='color:red;'>Deleted</h1>";
                                } else {
                                    ?>
                                    <div class="form-group">
                                        <div class="col-sm-10">
        <?= $this->Form->submit('Save', ['type' => 'submit', 'class' => 'btn btn-success', 'style' => 'margin-left:15px;']) ?>
                                        </div>
                                    </div>
                            <?php } ?>
                            </div>
    <?php } ?>
  <script>
        $(document).ready(function () {
       
        $('#profile_data').validate({
                errorElement: "span",
               
            rules:{
                'season[]': {required:true},
                'take_note_of[]': {required:true},
                'skin_tone[]': {required:true},
                'better_body_shape[]': {required:true},
                            
                'available_status': {required:true},  
            },
             messages: {
                'season[]': {
                    required: "Please select the season",

                },
            }
        });
     

    });
    </script>
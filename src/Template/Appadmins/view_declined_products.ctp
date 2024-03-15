<div class="content-wrapper">
    <section class="content-header">
        <center>
            <h1>DECLINED PRODUCT LIST</h1>
        </center>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <?php
                        foreach ($prData as $data) {
                            $img_dd = "";
                            $img_dd = strstr($data->product_image, PRODUCT_IMAGES) ? $data->product_image : PRODUCT_IMAGES . $data->product_image;
                            ?>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-6">

                                                <!--<h3><strong>Rack:</strong> <?php echo $data['in_rack']; ?></h3>-->
                                    <h4><?php echo $data['product_name_one']; ?></h4>
                                    <h5><?php echo $data['product_name_two']; ?></h5>

                                    <h6><strong>SIZE:</strong><span><?php echo $data['size']; ?></span></h6>
                                    <h6><strong>COLOR:</strong> <span><?php echo $data['color']; ?></span></h6>
                                    <h6><strong>Bar code:</strong> <span><?php echo $data['barcode_value']; ?></span></h6>

                                    <h6><strong>Price:</strong><span>$ <?php echo number_format($data['sell_price'], 2); ?></span></h6>
                                </div>
                                <div class="col-sm-4">
                                    <img  width="200" src="<?php echo HTTP_ROOT; ?><?= $img_dd; ?>"/>

                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                            <hr>

                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
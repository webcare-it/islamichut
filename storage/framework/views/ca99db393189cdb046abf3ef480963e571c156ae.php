

<?php $__env->startSection('content'); ?>
<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6"><?php echo e(translate('Product Information')); ?></h5>
</div>

<div class="">
    <form class="form form-horizontal mar-top" action="<?php echo e(route('products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data" id="choice_form">
        <input name="_method" type="hidden" value="POST">
        <input type="hidden" name="id" value="<?php echo e($product->id); ?>">
        <input type="hidden" name="lang" value="<?php echo e($lang); ?>">
        <!-- Add hidden b_product_id field if it exists -->
        <?php if(isset($product->b_product_id)): ?>
        <input type="hidden" name="b_product_id" value="<?php echo e($product->b_product_id); ?>">
        <?php endif; ?>
        <div class="row gutters-5 ">
            <div class="col-lg-12">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6"><?php echo e(translate('Product Information')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Product Name')); ?> <i class="las la-language text-danger" title="<?php echo e(translate('Translatable')); ?>"></i></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name" placeholder="<?php echo e(translate('Product Name')); ?>" value="<?php echo e($product->getTranslation('name', $lang)); ?>" onchange="update_sku()" required>
                            </div>
                        </div>
                        <div class="form-group row" id="category">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Category')); ?></label>
                            <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" name="category_id" id="category_id" data-selected="<?php echo e($product->category_id); ?>" data-live-search="true" required>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->getTranslation('name')); ?></option>
                                    <?php $__currentLoopData = $category->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('categories.child_category', ['child_category' => $childCategory], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="brand">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Brand')); ?></label>
                            <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" name="brand_id" id="brand_id" data-live-search="true">
                                    <option value=""><?php echo e(translate('Select Brand')); ?></option>
                                    <?php $__currentLoopData = \App\Models\Brand::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($brand->id); ?>" <?php if($product->brand_id == $brand->id): ?> selected <?php endif; ?>><?php echo e($brand->getTranslation('name')); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Unit')); ?> <i class="las la-language text-danger" title="<?php echo e(translate('Translatable')); ?>"></i> </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="unit" placeholder="<?php echo e(translate('Unit (e.g. KG, Pc etc)')); ?>" value="<?php echo e($product->getTranslation('unit', $lang)); ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Minimum Purchase Qty')); ?></label>
                            <div class="col-md-8">
                                <input type="number" lang="en" class="form-control" name="min_qty" value="<?php if($product->min_qty <= 1): ?><?php echo e(1); ?><?php else: ?><?php echo e($product->min_qty); ?><?php endif; ?>" min="1" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Tags')); ?></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control aiz-tag-input" name="tags[]" id="tags" value="<?php echo e($product->tags); ?>" placeholder="<?php echo e(translate('Type to add a tag')); ?>" data-role="tagsinput">
                            </div>
                        </div>

                        <?php if(addon_is_activated('pos_system')): ?>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Barcode')); ?></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="barcode" placeholder="<?php echo e(translate('Barcode')); ?>" value="<?php echo e($product->barcode); ?>">
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if(addon_is_activated('refund_request')): ?>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Refundable')); ?></label>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0" style="margin-top:5px;">
                                    <input type="checkbox" name="refundable" <?php if($product->refundable == 1): ?> checked <?php endif; ?>>
                                    <span class="slider round"></span></label>
                                </label>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6"><?php echo e(translate('Product Images')); ?></h5>
                    </div>
                    <div class="card-body">

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail"><?php echo e(translate('Gallery Images')); ?></label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium"><?php echo e(translate('Browse')); ?></div>
                                    </div>
                                    <div class="form-control file-amount"><?php echo e(translate('Choose File')); ?></div>
                                    <input type="hidden" name="photos" value="<?php echo e($product->photos); ?>" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail"><?php echo e(translate('Thumbnail Image')); ?> <small>(290x300)</small></label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium"><?php echo e(translate('Browse')); ?></div>
                                    </div>
                                    <div class="form-control file-amount"><?php echo e(translate('Choose File')); ?></div>
                                    <input type="hidden" name="thumbnail_img" value="<?php echo e($product->thumbnail_img); ?>" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6"><?php echo e(translate('Product Videos')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Video Provider')); ?></label>
                            <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" name="video_provider" id="video_provider">
                                    <option value="youtube" <?php if ($product->video_provider == 'youtube') echo "selected"; ?> ><?php echo e(translate('Youtube')); ?></option>
                                    <option value="dailymotion" <?php if ($product->video_provider == 'dailymotion') echo "selected"; ?> ><?php echo e(translate('Dailymotion')); ?></option>
                                    <option value="vimeo" <?php if ($product->video_provider == 'vimeo') echo "selected"; ?> ><?php echo e(translate('Vimeo')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Video Link')); ?></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="video_link" value="<?php echo e($product->video_link); ?>" placeholder="<?php echo e(translate('Video Link')); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Conditional Product Variation - hide when b_product_id exists -->
                <?php if(!isset($product->b_product_id)): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6"><?php echo e(translate('Product Variation')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row gutters-5">
                            <div class="col-md-3">
                                <input type="text" class="form-control" value="<?php echo e(translate('Colors')); ?>" disabled>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" data-live-search="true" data-selected-text-format="count" name="colors[]" id="colors" multiple>
                                    <?php $__currentLoopData = \App\Models\Color::orderBy('name', 'asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($color->code); ?>"
                                        data-content="<span><span class='size-15px d-inline-block mr-2 rounded border' style='background:<?php echo e($color->code); ?>'></span><span><?php echo e($color->name); ?></span></span>"
                                        <?php if (in_array($color->code, json_decode($product->colors))) echo 'selected' ?>
                                        ></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input value="1" type="checkbox" id="colors_active" name="colors_active" <?php if(count(json_decode($product->colors)) > 0): ?> checked <?php endif; ?>>
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row gutters-5">
                            <div class="col-md-3">
                                <input type="text" class="form-control" value="<?php echo e(translate('Attributes')); ?>" disabled>
                            </div>
                            <div class="col-md-8">
                                <select name="choice_attributes[]" id="choice_attributes" class="form-control aiz-selectpicker" multiple data-placeholder="<?php echo e(translate('Choose Attributes')); ?>">
                                    <?php $__currentLoopData = \App\Models\Attribute::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($attribute->id); ?>" <?php if(in_array($attribute->id, json_decode($product->attributes))): ?> selected <?php endif; ?>><?php echo e($attribute->getTranslation('name')); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="row" id="customer_choice_options">
                            <?php $__currentLoopData = json_decode($product->attributes); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $attribute_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $attribute = \App\Models\Attribute::find($attribute_id);
                            ?>
                            <?php if($attribute): ?>
                            <div class="col-md-3">
                                <input type="hidden" name="choice_no[]" value="<?php echo e($attribute->id); ?>">
                                <input type="text" class="form-control" value="<?php echo e($attribute->getTranslation('name')); ?>" placeholder="<?php echo e(translate('Choice Title')); ?>" disabled>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control aiz-selectpicker attribute_choice" data-live-search="true" name="choice_options_<?php echo e($attribute->id); ?>[]" multiple>
                                    <?php $__currentLoopData = $attribute->attribute_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $attribute_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($attribute_value->value); ?>" <?php if(in_array($attribute_value->value, json_decode($product->choice_options)->{$attribute->id} ?? [])): ?> selected <?php endif; ?>><?php echo e($attribute_value->value); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6"><?php echo e(translate('Product price + stock')); ?></h5>
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Unit price')); ?></label>
                            <div class="col-md-6">
                                <input type="text" placeholder="<?php echo e(translate('Unit price')); ?>" name="unit_price" class="form-control" value="<?php echo e($product->unit_price); ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
	                        <label class="col-sm-3 control-label" for="start_date"><?php echo e(translate('Discount Date Range')); ?></label>
	                        <div class="col-sm-9">
	                          <input type="text" class="form-control aiz-date-range" name="date_range" placeholder="<?php echo e(translate('Select Date')); ?>" data-time-picker="true" data-format="DD-MM-Y HH:mm:ss" data-separator=" to " autocomplete="off">
	                        </div>
	                    </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Discount')); ?></label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" step="0.01" placeholder="<?php echo e(translate('Discount')); ?>" name="discount" class="form-control" value="<?php echo e($product->discount); ?>" required>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control aiz-selectpicker" name="discount_type" required>
                                    <option value="amount" <?php if ($product->discount_type == 'amount') echo "selected"; ?> ><?php echo e(translate('Flat')); ?></option>
                                    <option value="percent" <?php if ($product->discount_type == 'percent') echo "selected"; ?> ><?php echo e(translate('Percent')); ?></option>
                                </select>
                            </div>
                        </div>

                        <?php if(\App\Models\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Models\Addon::where('unique_identifier', 'club_point')->first()->activated): ?>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">
                                <?php echo e(translate('Set Point')); ?>

                            </label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" step="1" placeholder="<?php echo e(translate('1')); ?>" name="earn_point" class="form-control" value="<?php echo e($product->earn_point); ?>" required>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('SKU')); ?></label>
                            <div class="col-md-6">
                                <input type="text" placeholder="<?php echo e(translate('SKU')); ?>" name="sku" class="form-control" value="<?php echo e($product->sku); ?>">
                            </div>
                        </div>
                        
                        <!-- Show/hide div for non-variable products -->
                        <div id="show-hide-div" style="<?php echo e($product->variant_product ? 'display:none;' : ''); ?>">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label"><?php echo e(translate('Quantity')); ?> <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" value="<?php echo e($product->stocks->first() ? $product->stocks->first()->qty : 0); ?>" step="1" placeholder="<?php echo e(translate('Quantity')); ?>" name="current_stock" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    <?php echo e(translate('SKU')); ?>

                                </label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="<?php echo e(translate('SKU')); ?>" value="<?php echo e($product->stocks->first() ? $product->stocks->first()->sku : ''); ?>" name="sku_single" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <?php if($product->variant_product == 1): ?>
                        <!-- SKU Combination Section -->
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Variants')); ?></label>
                            <div class="col-md-9">
                                <div class="sku_combination" id="sku_combination">
                                    <!-- This will be populated by AJAX -->
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6"><?php echo e(translate('Product Description')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Description')); ?></label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="description"><?php echo e($product->getTranslation('description', $lang)); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6"><?php echo e(translate('PDF Specification')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail"><?php echo e(translate('PDF Specification')); ?></label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="document">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium"><?php echo e(translate('Browse')); ?></div>
                                    </div>
                                    <div class="form-control file-amount"><?php echo e(translate('Choose File')); ?></div>
                                    <input type="hidden" name="pdf" value="<?php echo e($product->pdf); ?>" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6"><?php echo e(translate('SEO Meta Tags')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Meta Title')); ?></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="meta_title" value="<?php echo e($product->meta_title); ?>" placeholder="<?php echo e(translate('Meta Title')); ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Description')); ?></label>
                            <div class="col-md-8">
                                <textarea name="meta_description" rows="8" class="form-control"><?php echo e($product->meta_description); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail"><?php echo e(translate('Meta Images')); ?></label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium"><?php echo e(translate('Browse')); ?></div>
                                    </div>
                                    <div class="form-control file-amount"><?php echo e(translate('Choose File')); ?></div>
                                    <input type="hidden" name="meta_img" value="<?php echo e($product->meta_img); ?>" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Slug')); ?></label>
                            <div class="col-md-8">
                                <input type="text" placeholder="<?php echo e(translate('Slug')); ?>" name="slug" class="form-control" value="<?php echo e($product->slug); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 text-right">
                    <button type="submit" name="button" class="btn btn-primary"><?php echo e(translate('Update Product')); ?></button>
                </div>
            </div>
            
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    $(document).ready(function (){
        show_hide_shipping_div();
    });

    $("[name=shipping_type]").on("change", function (){
        show_hide_shipping_div();
    });

    function show_hide_shipping_div() {
        var shipping_val = $("[name=shipping_type]:checked").val();

        $(".product_wise_shipping_div").hide();
        $(".flat_rate_shipping_div").hide();
        if(shipping_val == 'product_wise'){
            $(".product_wise_shipping_div").show();
        }
        if(shipping_val == 'flat_rate'){
            $(".flat_rate_shipping_div").show();
        }

    }

    function add_more_customer_choice_option(i, name){
        $('#customer_choice_options').append('<div class="row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="'+i+'"><input type="text" class="form-control" name="choice[]" value="'+name+'" placeholder="<?php echo e(translate('Choice Title')); ?>" readonly></div><div class="col-md-8"><input type="text" class="form-control aiz-tag-input" name="choice_options_'+i+'[]" placeholder="<?php echo e(translate('Enter choice values')); ?>" data-role="tagsinput" onchange="update_sku()"></div></div>');

        AIZ.plugins.tagify();
    }

    $('input[name="colors_active"]').on('change', function() {
        if(!$('input[name="colors_active"]').is(':checked')){
            $('#colors').prop('disabled', true);
            AIZ.plugins.bootstrapSelect('refresh');
        }
        else{
            $('#colors').prop('disabled', false);
            AIZ.plugins.bootstrapSelect('refresh');
        }
        update_sku();
    });

    $(document).on("change", ".attribute_choice",function() {
        update_sku();
    });

    $('#colors').on('change', function() {
        update_sku();
    });

    function delete_row(em){
        $(em).closest('.form-group').remove();
        update_sku();
    }

    function delete_variant(em){
        $(em).closest('.variant').remove();
    }

    function update_sku(){
        $.ajax({
           type:"POST",
           url:'<?php echo e(route('products.sku_combination_edit')); ?>',
           data:$('#choice_form').serialize(),
           success: function(data){
               $('#sku_combination').html(data);
               AIZ.plugins.fooTable();
               AIZ.uploader.previewGenerate();
               // Check if we have variants in the returned HTML
               var variantCount = $(data).find('.variant').length;
               if (variantCount > 0) {
                   $('#show-hide-div').hide();
               } else {
                   $('#show-hide-div').show();
               }
           },
           error: function(){
               console.log('Error updating SKU combinations');
           }
       });
    }

    AIZ.plugins.tagify();

    $(document).ready(function(){
        // Only load variants if this is a variant product
        <?php if($product->variant_product == 1): ?>
            update_sku();
        <?php endif; ?>

        $('.remove-files').on('click', function(){
            $(this).parents('.col-md-4').remove();
        });
    });

    $('#choice_attributes').on('change', function() {
        $.each($("#choice_attributes option:selected"), function(j, attribute){
            flag = false;
            $('input[name="choice_no[]"]').each(function(i, choice_no) {
                if($(attribute).val() == $(choice_no).val()){
                    flag = true;
                }
            });
            if(!flag){
                add_more_customer_choice_option($(attribute).val(), $(attribute).text());
            }
        });

        var choices = [];
        $.each($("#choice_attributes option:selected"), function(){
            choices.push($(this).val());
        });

        $.post('<?php echo e(route('products.edit')); ?>', {_token:'<?php echo e(csrf_token()); ?>', choices:choices, id:<?php echo e($product->id); ?>}, function(data){
            $('#customer_choice_options').html(data);
            AIZ.plugins.bootstrapSelect('refresh');
            AIZ.plugins.fooTable();
            update_sku();
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Ecommerce4\resources\views/backend/product/products/edit.blade.php ENDPATH**/ ?>
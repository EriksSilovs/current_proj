<?php
$titleOI = get_field("title_oi", "options");
$textOI = get_field("text_oi", "options");
$sidePicture = get_field("side_picture", "options");
//FORM placeholders
$nameForm = get_field("name_form", "options");
$nrGuestsPlaceholder = get_field("number_of_guests_placeholder", "options");
$nrGuests = get_field("number_of_guests_form", "options");
$phoneNrForm = get_field("phone_number_form", "options");
$emailForm = get_field("email_address_form", "options");
$dateForm = get_field("visit_date_form", "options");
$timeForm = get_field("visit_time_form", "options");
$extraTextForm = get_field("extra_text_form", "options");
//submit button
$submitForm = get_field("form_submit_button_text", "options");
?>
<div class="register-info">
    <!--LEFT-->
    <div class="left-inf wysiwyg-style">
        <?php //TITLE
             if ( !is_page_template("reservation.php")){ echo "<h2> {$titleOI} </h2>"; }
              //TEXT
             if ($textOI) { echo "<div class=\"form-text-wrapper wysiwyg-style\"> {$textOI} </div>"; }?>
        <form action="" method="post" class="contact-form" id="contact-form" novalidate>
            <div class="form-input-fields">
                <div class="single-input">
                    <input  <?php if ($nameForm) echo "placeholder=\"{$nameForm}\""; ?>  type="text" name="form-name" class="input-name"><div class="dot-decoration" ><img src="<?php bloginfo("template_url"); ?>/images/icons/ellipse.svg"></div>
                </div>
                <div class="single-input">
                    <div class="selectric-wrapper">
                        <select class="selectric" name="form-guest-count" style="opacity: 0">
                            <option <?php if ($nrGuestsPlaceholder) echo "placeholder=\"{$nrGuestsPlaceholder}\""; ?> selected><?= $nrGuestsPlaceholder?></option>
                            <?php  foreach ($nrGuests as $guests) { ?>
                                <option value="<?= $guests["number"] ?>"><?= $guests["number"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="dot-decoration"><img src="<?php bloginfo("template_url"); ?>/images/icons/ellipse.svg"></div>
                </div>
                <div class="single-input">
                    <input <?php if ($phoneNrForm) echo "placeholder=\"{$phoneNrForm}\""; ?>  name="form-phone" class="input-phone" class="no-arrow" type="number">
                    <div class="dot-decoration"><img src="<?php bloginfo("template_url"); ?>/images/icons/ellipse.svg"></div>
                </div>
                <div class="single-input">
                    <input <?php if ($emailForm) echo "placeholder=\"{$emailForm}\""; ?> type="email"  name="form-email" class="input-email" >
                    <div class="dot-decoration"><img src="<?php bloginfo("template_url"); ?>/images/icons/ellipse.svg"></div>
                </div>
                <div class="single-input united-inputs d-flex justify-content-between">
                    <input <?php if ($dateForm) echo "placeholder=\"{$dateForm}\""; ?> type="text" name="form-date" class="date-input date-picker">
                    <input <?php if ($timeForm) echo "placeholder=\"{$timeForm}\""; ?> type="text" name="form-time" class="time-input timepicker">
                    <div class="dot-decoration"><img src="<?php bloginfo("template_url"); ?>/images/icons/ellipse.svg"></div>
                </div>
                <div class="single-input">
                    <input <?php if ($extraTextForm) echo "placeholder=\"{$extraTextForm}\""; ?> type="text" name="form-message" class="input-message">
                    <div class="dot-decoration"><img src="<?php bloginfo("template_url"); ?>/images/icons/ellipse.svg"></div>
                </div>
            </div>
            <div class="position-relative">
                <input class="button button-black prevent-shaking-animation button-hover-shadow" type="submit" <?php if ($submitForm) echo "value=\"{$submitForm}\""; ?> >
                <img src="<?php bloginfo("template_url"); ?>/images/icons/preloader.png" class="preloader preloader-subscribe position-absolute">
                <div class="warning-message non-valid-email-warning w-100" style="display: none;"><?= __("E-pasts nav derīgs", "Bangerts"); ?></div>
                <div class="warning-message empty-field-warning w-100" style="display: none;"><?= __("Nav ievadīta visa nepieciešāmā informācija", "Bangerts"); ?></div>
            </div>
        </form>
        <div class="success-submit-wrapper">
            <div class="success-message d-flex justify-content-start align-items-center"><?= __("VEIKSMĪGA REZEVĀCIJA", "Bangerts"); ?></div>
        </div>
    </div>
    <!--RIGHT-->
    <?php if ($sidePicture) { ?>
        <div class="right-inf">
            <img src="<?= $sidePicture["sizes"]["medium_large"]; ?>" alt="<?= $sidePicture["alt"]; ?>">
        </div>
    <?php } ?>
</div>
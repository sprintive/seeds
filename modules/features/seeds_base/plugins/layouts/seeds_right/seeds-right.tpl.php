<div class="<?php print $classes ?>" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>

  <?php if ($content['separator']): ?>
    <div class="clearfix separator-0 separator">
        <?php print $content['separator']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

  <?php if ($content['left'] || $content['right']): ?>
    <div class="row-wrapper-1">
      <div class="container clearfix">
        <div class="row">
          <div class="col-sm-8">
            <?php if ($content['left']) print $content['left']; ?>
            <div class="panel-separator"></div>
          </div>
          <div class="col-sm-4">
            <?php if ($content['right']) print $content['right']; ?>
            <div class="panel-separator"></div>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>

  <?php if ($content['separator1']): ?>
    <div class="clearfix separator-1 separator">
        <?php print $content['separator1']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

   <?php if ($content['separator2']): ?>
    <div class="clearfix separator-2 separator">
        <?php print $content['separator2']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

  <?php if ($content['left1'] || $content['right1']): ?>
    <div class="row-wrapper-2">
      <div class="container clearfix">
      	<div class="row">
          <div class="col-sm-8">
            <?php if ($content['left1']) print $content['left1']; ?>
            <div class="panel-separator"></div>
          </div>
          <div class="col-sm-4">
            <?php if ($content['right1']) print $content['right1']; ?>
            <div class="panel-separator"></div>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>

  <?php if ($content['separator3']): ?>
    <div class="clearfix separator-3 separator">
        <?php print $content['separator3']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

   <?php if ($content['separator4']): ?>
    <div class="clearfix separator-4 separator">
        <?php print $content['separator4']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

  <?php if ($content['left2'] || $content['right2']): ?>
    <div class="row-wrapper-3">
      <div class="container clearfix">
        <div class="row">
          <div class="col-sm-8">
            <?php if ($content['left2']) print $content['left2']; ?>
            <div class="panel-separator"></div>
          </div>
          <div class="col-sm-4">
            <?php if ($content['right2']) print $content['right2']; ?>
            <div class="panel-separator"></div>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>

  <?php if ($content['separator5']): ?>
    <div class="clearfix separator-5 separator">
        <?php print $content['separator5']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

   <?php if ($content['separator6']): ?>
    <div class="clearfix separator-6 separator">
        <?php print $content['separator6']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

</div>

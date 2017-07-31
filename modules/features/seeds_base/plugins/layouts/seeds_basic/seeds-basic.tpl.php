<div class="<?php print $classes ?>" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
   
  <?php if ($content['separator']): ?>
    <div class="clearfix separator separator-0">
      <?php print $content['separator']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

  <?php if ($content['separator1']): ?>
    <div class="clearfix separator separator-1">
      <?php print $content['separator1']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

  <?php if ($content['separator2']): ?>
    <div class="clearfix separator separator-2">
      <?php print $content['separator2']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

  <?php if ($content['left'] || $content['middle'] || $content['right']): ?>
    <div class="region-3-col">
      <div class="container">
          <div class="col-sm-4">
            <?php if ($content['left']) print $content['left']; ?>
            <div class="panel-separator"></div>
          </div>
          <div class="col-sm-4">
            <?php if ($content['middle']) print $content['middle']; ?>
            <div class="panel-separator"></div>
          </div>
          <div class="col-sm-4">
            <?php if ($content['right']) print $content['right']; ?>
            <div class="panel-separator"></div>
          </div>
      </div>
    </div>
  <?php endif ?>

  <?php if ($content['separator3']): ?>
    <div class="clearfix separator separator-3">
      <?php print $content['separator3']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

  <?php if ($content['separator4']): ?>
    <div class="clearfix separator separator-4">
      <?php print $content['separator4']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

  <?php if ($content['separator5']): ?>
    <div class="clearfix separator separator-5">
      <?php print $content['separator5']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

  <?php if ($content['separator6']): ?>
    <div class="clearfix separator separator-6">
      <?php print $content['separator6']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

  
  <?php if ($content['left1'] || $content['right1'] || $content['right2'] || $content['left2']): ?>
    <div class="three-col-wrapper-0">
      <div class="container">
        <div class="row">
          <?php if ($content['left1'] || $content['right2'] || $content['left2']): ?>
            <div class="col-sm-8">
              <?php if ($content['left1']): ?>
                <?php print $content['left1']; ?>
                <div class="panel-separator"></div>
              <?php endif; ?>
              <div class="row">
                <div class="col-sm-6">
                  <?php if ($content['left2']): ?>
                    <?php print $content['left2']; ?>
                     <div class="panel-separator"></div>
                   <?php endif; ?>
                </div>
                <div class="col-sm-6">
                  <?php if ($content['right2']): ?>
                    <?php print $content['right2']; ?>
                    <div class="panel-separator"></div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endif ?>
          <div class="col-sm-4">
            <?php if ($content['right1']):?>
              <?php print $content['right1']; ?>
              <div class="panel-separator"></div>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>

  <?php if ($content['separator7']): ?>
    <div class="clearfix separator separator-7">
      <?php print $content['separator7']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

  <?php if ($content['separator8']): ?>
    <div class="clearfix separator separator-8">
      <?php print $content['separator8']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>
  
  <?php if ($content['left3'] || $content['right3'] || $content['right4'] || $content['left4']): ?>
    <div class="three-col-wrapper-1">
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <?php if ($content['left3']):?>
              <?php print $content['left3']; ?>
              <div class="panel-separator"></div>
            <?php endif;?>
          </div>
          <?php if ($content['right3'] || $content['right4'] || $content['left4']): ?>
            <div class="col-sm-8">
              <?php if ($content['right3']):?>
                <?php print $content['right3']; ?>
                <div class="panel-separator"></div>
              <?php endif;?>
              <div class="row">
                <div class="col-sm-6">
                  <?php if ($content['left4']):?>
                    <?php print $content['left4']; ?>
                    <div class="panel-separator"></div>
                  <?php endif;?>
                </div>
                <div class="col-sm-6">
                  <?php if ($content['right4']):?>
                    <?php print $content['right4']; ?>
                    <div class="panel-separator"></div>
                  <?php endif;?>
                </div>
              </div>
            </div>
          <?php endif ?>
        </div>
      </div>
    </div>
  <?php endif ?>
  
  <?php if ($content['separator9']): ?>
    <div class="clearfix separator separator-9">
      <?php print $content['separator9']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

    <?php if ($content['separator10']): ?>
    <div class="clearfix separator separator-10">
      <?php print $content['separator10']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>

    <?php if ($content['separator11']): ?>
    <div class="clearfix separator separator-11">
      <?php print $content['separator11']; ?>
    </div>
    <div class="panel-separator"></div>
  <?php endif ?>
</div>

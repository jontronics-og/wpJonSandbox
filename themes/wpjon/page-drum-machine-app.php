<?php
/**
* Template Name: Drum Machine App
*/



get_header(); 
?>

<div class="page-drum-machine">
  <div class="drum-machine">
      <div class="controls">
          <div class="drum-pad">
              <button type="button" id="kick-btn"></button>
              <label>KICK</label>
          </div>
          <div class="drum-pad">
              <button type="button" id="snare-btn"></button>
              <label>SNARE</label>
          </div>
          <div class="drum-pad">
              <button type="button" id="hihat-btn"></button>
              <label>HI-HAT</label>
          </div>
      </div>
      <div class="tempo-display">120.0</div>
      <div class="grid" id="sequencer-grid"></div>
      <div class="step-numbers" id="step-numbers">
          <?php for($i = 1; $i <= 16; $i++): ?>
              <div class="step-number"><?php echo $i; ?></div>
          <?php endfor; ?>
      </div>
      <div class="transport">
          <button id="play-button">PLAY</button>
          <button id="stop-button">STOP</button>
          <button id="clear-button">CLEAR</button>
      </div>
  </div>
</div>

<?php get_footer(); ?>
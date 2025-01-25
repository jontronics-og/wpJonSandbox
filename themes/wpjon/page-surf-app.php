<?php
/**
 * Template Name: Surf App
 */
get_header(); 
?>

<!-- In template-surf.php -->
<div class="page-wrapper">
    <div class="content-container">
        <h1 class="page-title">NY SURF CONDITIONS</h1>
        <p class="page-description">Only Ten API calls a day - Check Early Morning</p>
        <div class="button-timer-container">
            <div class="button-group">
                <button id="checkSurfBtn" class="check-surf-btn">
                    Check Surf Conditions
                </button>
                <button id="lastCheckedBtn" class="last-checked-btn" disabled>
                    Not checked yet
                </button>
            </div>
        </div>
        <div id="surfResults" class="surf-results"></div>
    </div>
</div>

<?php get_footer(); ?>
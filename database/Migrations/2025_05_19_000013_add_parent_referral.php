<?php
Schema::table('referrals', function(Blueprint $t){
    $t->foreignId('parent_id')->nullable()->constrained('referrals')->cascadeOnDelete();
});

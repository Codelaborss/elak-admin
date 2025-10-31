<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('slug')->nullable();
            $table->string('app_name')->nullable();
            $table->string('client_id')->nullable();
            $table->string('segment_ids')->nullable();
            $table->string('sub_category_ids')->nullable();
            $table->string('branch_ids')->nullable();
            $table->string('voucher_title')->nullable();
            $table->string('valid_until')->nullable();
            $table->string('voucher_ids')->nullable();
            $table->string('bundle_type')->enum("simple","fixed bundle" ,"buy x get y","mix and match");
            $table->string('tags_ids')->nullable();
            $table->string('how_and_condition_ids')->nullable();
            $table->string('term_and_condition_ids')->nullable();
            $table->string('product')->nullable();
            $table->string('product_b')->nullable();
            $table->string('required_quantity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('app_name')->nullable();
            $table->dropColumn('client_id')->nullable();
            $table->dropColumn('segment_ids')->nullable();
            $table->dropColumn('sub_category_ids')->nullable();
            $table->dropColumn('branch_ids')->nullable();
            $table->dropColumn('voucher_title')->nullable();
            $table->dropColumn('valid_until')->nullable();
            $table->dropColumn('voucher_ids')->nullable();
            $table->dropColumn('bundle_type')->enum("simple","fixed bundle" ,"buy x get y","mix and match");
            $table->dropColumn('tags_ids')->nullable();
            $table->dropColumn('how_and_condition_ids')->nullable();
            $table->dropColumn('term_and_condition_ids')->nullable();
            $table->dropColumn('product')->nullable();
            $table->dropColumn('product_b')->nullable();
            $table->dropColumn('required_quantity')->nullable();

        });
    }
}

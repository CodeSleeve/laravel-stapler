<?= '<?php' . PHP_EOL ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class <?= $className ?> extends Migration {

	/**
	 * Make changes to the table.
	 *
	 * @return void
	 */
	public function up()
	{	
		Schema::table('<?= $table ?>', function(Blueprint $table) {		
			
			$table->string('<?php echo $attachment ?>_file_name')->nullable();
			$table->integer('<?php echo $attachment ?>_file_size')->nullable();
			$table->string('<?php echo $attachment ?>_content_type')->nullable();
			$table->timestamp('<?php echo $attachment ?>_updated_at')->nullable();

		});

	}

	/**
	 * Revert the changes to the table.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('<?= $table ?>', function(Blueprint $table) {

			$table->dropColumn('<?php echo $attachment ?>_file_name');
			$table->dropColumn('<?php echo $attachment ?>_file_size');
			$table->dropColumn('<?php echo $attachment ?>_content_type');
			$table->dropColumn('<?php echo $attachment ?>_updated_at');

		});
	}

}

<?php

class ProjectTableSeeder extends Seeder
{

  /**
   * Class vars
   *
   * @var $faker object
   */
  private $faker, $seed;

  /**
   * Constructor
   */
  function __construct()
  {
    $this->faker = \Faker\Factory::create();
    $this->seed  = Config::get('app.seed_size');
  }

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    for($i=1;$i<=$this->seed;$i++) {
      DB::table('projects')->insert([
        'user_id'   => 1,
        'name'      => strtolower($this->faker->domainWord),
        'is_active' => true
      ]);
    }

    for($i=1;$i<=$this->seed*2;$i++) {
      $id = rand(1, $this->seed);

      $project   = DB::table('projects')->where('id', $id)->first();
      $type      = strtolower($this->faker->domainWord);
      $fields    = $this->getFields();
      $tableName = $project->name.'_'.$type;

      DB::table('projects_types')->insert([
        'project_id' => $id,
        'type'       => $type,
        'table_name' => $tableName,
        'fields'     => json_encode($fields),
      ]);

      Schema::create($tableName, function($table) use ($fields)
      {
        $table->increments('id');
        foreach($fields as $field) {
          $table->mediumText($field['field_name'])->nullable();
        }
      });

      for($j=0;$j<$this->seed*25;$j++) {
        $values = ['biff','marty','doc','jennifer','needles'];
        DB::table($tableName)->insert([
          'first_name' => $this->faker->firstName,
          'last_name'  => $this->faker->lastName,
          'happy'      => rand(0,1000) % 2 === 0 ? true : false,
          'character'  => $values[rand(0,4)],
          'kids'       => rand(0,1000) % 2 === 0 ? true : false,
        ]);
      }
    }
  }

  /**
   * Returns a set of fields
   *
   * @return string
   */
  private function getFields()
  {
    return [
      [
        "field_type"     => "text",
        "field_name"     => "first_name",
        "field_editable" => rand(0,1000) % 2 === 0 ? true : false,
        "field_values"   => null,
      ],
      [
        "field_type"     => "text",
        "field_name"     => "last_name",
        "field_editable" => rand(0,1000) % 2 === 0 ? true : false,
        "field_values"   => null,
      ],
      [
        "field_type"     => "checkbox",
        "field_name"     => "happy",
        "field_editable" => rand(0,1000) % 2 === 0 ? true : false,
        "field_values"   => null,
      ],
      [
        "field_type"     => "select",
        "field_name"     => "character",
        "field_editable" => rand(0,1000) % 2 === 0 ? true : false,
        "field_values"   => [
          ["value" => "biff", "label" => "Biff"],
          ["value" => "marty", "label" => "Marty"],
          ["value" => "doc", "label" => "Doc Brown"],
          ["value" => "jennifer", "label" => "Jennifer"],
          ["value" => "needles", "label" => "Needles"],
        ]
      ],
      [
        "field_type"     => "checkbox",
        "field_name"     => "kids",
        "field_editable" => rand(0,1000) % 2 === 0 ? true : false,
        "field_values"   => null,
      ],
    ];
  }

}

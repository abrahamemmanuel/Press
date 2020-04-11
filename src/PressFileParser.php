<?php
namespace emmy\Press;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PressFileParser
{
    protected $filename;
    protected $data;
    protected $rawData;

    public function __construct($filename)
    {
        $this->filename = $filename;

        $this->splitFile();

        $this->explodeData();

        $this->processFields();
    }

    public function getData()
    {
        return $this->data;
    }

    public function getRawData()
    {
        return $this->rawData;
    }

    protected function splitFile()
    {
        // regular expression
        preg_match('/^\-{3}(.*?)\-{3}(.*)/s',
            File::exists($this->filename) ? File::get($this->filename) : $this->filename,
            $this->rawData
        );

        // dd($this->data);
    }

    public function explodeData()
    {
        foreach (explode("\n", trim($this->rawData[1])) as $fieldString) {
            // dd($fieldString);

            // regular expression
            preg_match('/(.*):\s?(.*)/', $fieldString, $fieldArray);
            // dd($fieldArray);

            $this->data[$fieldArray[1]] = $fieldArray[2];
            // dd($fieldArray);
        }

        // save the blog body
        $this->data['body'] = trim($this->rawData[2]);
        //   dd(trim($this->data[2]));
    }

    public function processFields()
    {
        foreach ($this->data as $field => $value) {

            $class = ('emmy\\Press\\Fields\\' . Str::title($field));

            // check if class and method exist
            if (!class_exists($class) && !method_exists($class, "process")) {
              $class = 'emmy\\Press\\Fields\\Extra';
            }
            $this->data = array_merge($this->data, $class::process($field, $value, $this->data));
        }
    }
}

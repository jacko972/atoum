<?php

namespace mageekguy\atoum;

class report implements observer, adapter\aggregator
{
	protected $title = null;
	protected $locale = null;
	protected $adapter = null;
	protected $writers = array();
	protected $fields = array();
	protected $lastSetFields = array();

	public function __construct(locale $locale = null, adapter $adapter = null)
	{
		$this
			->setLocale($locale ?: new locale())
			->setAdapter($adapter ?: new adapter())
		;
	}

	public function setTitle($title)
	{
		$this->title = (string) $title;

		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setLocale(locale $locale)
	{
		$this->locale = $locale;

		return $this;
	}

	public function getLocale()
	{
		return $this->locale;
	}

	public function setAdapter(adapter $adapter)
	{
		$this->adapter = $adapter;

		return $this;
	}

	public function getAdapter()
	{
		return $this->adapter;
	}

	public function addField(report\field $field)
	{
		$this->fields[] = $field;

		return $this;
	}

	public function getFields()
	{
		return $this->fields;
	}

	public function getWriters()
	{
		return $this->writers;
	}

	public function handleEvent($event, observable $observable)
	{
		$this->lastSetFields = array();

		foreach ($this->fields as $field)
		{
			if ($field->handleEvent($event, $observable) === true)
			{
				$this->lastSetFields[] = $field;
			}
		}

		return $this;
	}

	public function __toString()
	{
		$string = '';

		foreach ($this->lastSetFields as $field)
		{
			$string .= $field;
		}

		return $string;
	}

	protected function doAddWriter($writer)
	{
		$this->writers[] = $writer;

		return $this;
	}
}

?>

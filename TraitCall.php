<?php

namespace introspection;

/**
 * Trait to define the magic method __call() through introspection.
 *
 * The methods set() and get() doesn't to be implemented on the classes that
 * use this trait.
 *
 *
 * @author 	Maycon Brito    mayconfsbrito@gmail.com
 */
trait TraitCall
{
	/**
	 * Verifica se a classe possui o atributo passado definido e emula o método
	 * set() ou get() invocado.
	 *
	 * @param  string $name
	 * @param  array $arguments
	 * @return miexed
	 */
    public function __call($name, $arguments)
    {
        $getMatches = preg_match('/^get([a-zA-Z0-9]+)$/', $name, $matches);
        if ($getMatches > 0) {
            $normalized = lcfirst($matches[1]);
            if (property_exists($this, $normalized)) {
                if (isset($this->$normalized)) {
                    return $this->$normalized;
                }
                return null;
            }
        }

        $setMatches = preg_match('/^set([a-zA-Z0-9]+)$/', $name, $matches);
        if ($setMatches > 0) {
            $normalized = lcfirst($matches[1]);
            if (property_exists($this, $normalized)) {
            	$this->$normalized = $arguments[0];

                return $this;
            }
            return null;
        }
    }
}

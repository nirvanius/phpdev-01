<?php
	class Node implements NodeInterface
	{
        static $hhh;
        // public $name;
        static $Node;
        // public $child;
        public function __construct(string $name) {
            $this->name = $name;
            $this->getChildren();
            $this->child = implode('', self::$Node);
        }
        public function __toString(): string {
            return $this->child;
        }
        
        public function getName(): string {
            return $this->name;
        }
    
        /**
         * @return Node[]
         */
        public function getChildren(): array {
            self::$hhh = self::$hhh.'+';
            self::$Node[] =self::$hhh;
            self::$Node[] =$this->name.'<br>';
           return self::$Node;
        }
    
        public function addChild(Node $node): NodeInterface
        {
            // self::$hhh = self::$hhh.'+';
            $this->node =  $node;
            return $this->node;
        }
    }
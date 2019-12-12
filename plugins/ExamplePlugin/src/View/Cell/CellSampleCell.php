<?php

    namespace ExamplePlugin\View\Cell;

    use Cake\View\Cell;

    /**
     * CellSample cell
     */
    class CellSampleCell extends Cell
    {
        /**
         * List of valid options that can be passed into this
         * cell's constructor.
         *
         * @var array
         */
        protected $_validCellOptions = [];

        /**
         * Initialization logic run at the end of object construction.
         *
         * @return void
         */
        public function initialize()
        {
        }

        /**
         * Default display method.
         *
         * @return void
         */
        public function display()
        {
        }

        public function testDisplay() {

        }
    }

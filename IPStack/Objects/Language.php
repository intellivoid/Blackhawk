<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Language.php
 *
 *
 * Created: 1/20/20, 1:04 PM
 * Last modified: 1/18/20, 2:41 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace IPStack\Objects;

    /**
     * Class Language
     * @package IPStack\Objects
     */
    class Language
    {
        /**
         * Returns the 2-letter language code for the given language.
         *
         * @var string
         */
        public $Code;

        /**
         * Returns the name (in the API request's main language) of the given language. (e.g. Portuguese)
         *
         * @var string
         */
        public $Name;

        /**
         * Returns the native name of the given language. (e.g. Português)
         *
         * @var string
         */
        public $Native;

        /**
         * Creates array from object
         *
         * @return array
         */
        public function toArray(): array
        {
            return array(
                'code' => $this->Code,
                'name' => $this->Name,
                'native' => $this->Native
            );
        }

        /**
         * Creates object from array
         *
         * @param array $data
         * @return Language
         */
        public static function fromArray(array $data): Language
        {
            $LanguageObject = new Language();

            if(isset($data['code']))
            {
                $LanguageObject->Code = (string)$data['code'];
            }

            if(isset($data['name']))
            {
                $LanguageObject->Name = (string)$data['name'];
            }

            if(isset($data['native']))
            {
                $LanguageObject->Native = (string)$data['native'];
            }

            return $LanguageObject;
        }
    }
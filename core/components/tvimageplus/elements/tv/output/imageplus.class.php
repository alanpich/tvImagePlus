<?php
require dirname(dirname(dirname(dirname(__FILE__)))) . '/lib/autoload.php';
if (!class_exists('ImagePlusOutputRender')) {
    class ImagePlusOutputRender extends ImagePlus\TV\OutputRender
    {


        public function process($value, array $params = array())
        {
            $data = $this->getImageData($value);

            if(empty($data))
                return '';

            $renderType = strtolower($params['type']);
            switch ($renderType) {
                case 'url':
                    return $this->processUrl($data, $params);
                    break;
                case 'chunk':
                    return $this->processChunk($data, $params);
                    break;
                case 'snippet':
                    return $this->processSnippet($data, $params);
                    break;
                case 'data uri':
                    return $this->processDataUri($data, $params);
                    break;
                default:
                    unset($data['image']);
                    echo '<pre>'.$renderType.'</pre>';
                    return json_encode($data);
            }
        }


        /**
         * Parse TV value and return an array of data
         * about the TV image
         *
         * @param string $value
         * @return array|null
         */
        protected function getImageData($value)
        {
            $data = json_decode($value);
            if(is_null($data)||!isset($data->uid))
                return NULL;

            $image = $this->imagePlus->getImage((int)$data->uid);

            $array = array(
                'uid' => $data->uid,
                'url' => $image->getCacheUrl(),
                'width' => $image->get('output_width'),
                'height' => $image->get('output_height'),
                'mtime' => $image->get('mtime'),
                'original' => $image->getOriginalImageUrl(),
                'alt' => $data->alt,
                'image' => $image
            );

            return $array;
        }


        /**
         * URL Output type
         *
         * @param $data
         * @param array $params
         * @return string
         */
        protected function processUrl($data, $params)
        {
            if (!empty($data)){
                return $data['url'];
            }
            return '';
        }


        /**
         * Chunk Output type
         *
         * @param $data
         * @param array $params
         * @return string
         */
        protected function processChunk($data, $params)
        {
            if(empty($data) || !isset($params['chunk']))
                return '';

            /** @var \modChunk $chunk */
            $chunk = $this->modx->getObject('modChunk',(int)$params['chunk']);
            if(!empty($chunk)){
                unset($data['image']);
                return $chunk->process($data);
            };
            return '';
        }

        /**
         * Snippet Output type
         *
         * @param $data
         * @param array $params
         * @return string
         */
        protected function processSnippet($data, $params)
        {
            if(empty($data) || !isset($params['snippet']))
                return '';

            /** @var \modChunk $snippet */
            $snippet = $this->modx->getObject('modSnippet',(int)$params['snippet']);
            if(!empty($snippet))
                return $snippet->process($data);
            return '';
        }


        /**
         * DataURI Output type
         *
         * @param $data
         * @param array $params
         * @return string
         */
        protected function processDataUri($data, $params)
        {
            if(empty($data) || !isset($data['image']))
                return '';

            /** @var ImagePlusImage $image */
            $image = $data['image'];
            $content = $image->getAsDataUri();
            $base64 = '';
            if(!empty($content)){
                $base64 = 'data:image/jpeg;base64,'.base64_encode($content);
            }
            return $base64;
        }


    }
}
return "ImagePlusOutputRender";
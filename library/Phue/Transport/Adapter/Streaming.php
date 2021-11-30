<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */
namespace Phue\Transport\Adapter;

/**
 * Streaming Http adapter
 */
class Streaming implements AdapterInterface
{

    /**
     * Stream context
     *
     * @var resource
     */
    protected $streamContext;

    /**
     * File stream
     *
     * @var resource
     */
    protected $fileStream;

    /**
     * Opens the connection
     */
    public function open()
    {
        // Deliberately do nothing
    }

    /**
     * Sends request
     *
     * @param string $address
     *            Request path
     * @param string $method
     *            Request method
     * @param string $body
     *            Body data
     *
     * @return string Result
     */
    public function send($address, $method, $body = null)
    {
        // Init stream options
        $streamOptions = array(
            'ignore_errors' => true,
            'method' => $method
        );
        
        // Set body if there is one
        if (strlen($body)) {
            $streamOptions['content'] = $body;
        }
        
        $this->streamContext = stream_context_create(
            array(
                'http' => $streamOptions
            )
        );
        
        // Make request
            $this->fileStream = @fopen($address, 'r', false, $this->streamContext);
        
            return $this->fileStream ? stream_get_contents($this->fileStream) : false;
    }

    /**
     * Get response http status code
     *
     * @return string Response http code
     */
    public function getHttpStatusCode()
    {
        preg_match('#^HTTP/1\.1 (\d+)#mi', $this->getHeaders(), $matches);
        
        return isset($matches[1]) ? $matches[1] : false;
    }

    /**
     * Get response content type
     *
     * @return string Response content type
     */
    public function getContentType()
    {
        preg_match('#^Content-type: ([^;]+?)$#mi', $this->getHeaders(), $matches);
        
        return isset($matches[1]) ? $matches[1] : false;
    }

    /**
     * Get headers
     *
     * @return string Headers
     */
    public function getHeaders()
    {
        // Don't continue if file stream isn't valid
        if (! $this->fileStream) {
            return;
        }
        
        $meta_data = stream_get_meta_data($this->fileStream);
        return implode(
            $meta_data['wrapper_data'],
            "\n"
        );
    }

    /**
     * Closes the streaming connection
     */
    public function close()
    {
        if (is_resource($this->fileStream)) {
            fclose($this->fileStream);
        }
        
        $this->streamContext = null;
    }
}

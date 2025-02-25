<?php

namespace ColdBlader\MeiTuan;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Utils;
use ColdBlader\MeiTuan\Exceptions\ServiceException;
use HughCube\GuzzleHttp\Client as HttpClient;
use HughCube\GuzzleHttp\HttpClientTrait;
use Psr\Http\Client\ClientExceptionInterface as HttpClientException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Client
{
    use HttpClientTrait {
        getHttpClient as public;
    }

    /**
     * @var Config
     */
    protected  $config;

    public function __construct(array $config)
    {
        $this->config = new Config($config);
    }

    
    public function getConfig(): Config
    {
        return $this->config;
    }
    

    protected function createHttpClient():HttpClient{
        $config = $this->getConfig()->getHttp();
        $config['handler'] = $handler = HandlerStack::create();


         /** 签名 */
         $handler->push(function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                $stringBody = (string) $request->getBody();
                parse_str($stringBody, $params);

                unset($params['sign']);
                $params = array_merge(['charset' => 'UTF-8'], $params);
                $params = array_merge(['timestamp' => time()],$params);
                $params = array_merge(['developerId' => $this->getConfig()->getDeveloperId()],$params);
                $params = array_merge(['businessId'=>$this->getConfig()->getBusinessId()],$params);

                $params['sign'] = Sign::makeSign(
                    $this->getConfig()->getSignKey(),
                    Sign::makeContent($params)
                );


                $request = $request->withBody(Utils::streamFor(http_build_query($params)));

                return $handler($request, $options);
            };
        });

        /** 输出请求debug信息 */
        $handler->push(function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                /** @var Promise $promise */
                $promise = $handler($request, $options);

                return $promise->then(function (ResponseInterface $response) use ($request, $options) {
                    if ($this->getConfig()->enableDebug() || true === boolval($options['extra']['debug'] ?? false)) {
                        echo sprintf('> %s %s', $request->getMethod(), strval($request->getUri())), PHP_EOL;
                        foreach ($request->getHeaders() as $name => $values) {
                            foreach ($values as $value) {
                                echo sprintf('> %s: %s', $name, $value), PHP_EOL;
                            }
                        }

                        echo '>', PHP_EOL;
                        $request->getBody()->rewind();
                        $data = mb_substr($request->getBody()->read(min(1000, $request->getBody()->getSize())), 0, 100);
                        if ($request->getBody()->getSize() > 10 * 1024) {
                            echo sprintf('* Failure writing output to destination, returned %s.', $request->getBody()->getSize()), PHP_EOL;
                        } elseif (!mb_check_encoding($data, 'UTF-8')) {
                            echo '* Binary output can mess up your terminal.', PHP_EOL;
                        } elseif (empty($data)) {
                            echo PHP_EOL, '* Request completely sent off', PHP_EOL;
                        } else {
                            $request->getBody()->rewind();
                            echo sprintf('> %s', $request->getBody()->getContents()), PHP_EOL;
                            echo '* Request completely sent off', PHP_EOL;
                        }

                        echo PHP_EOL;

                        echo sprintf('< %s %s', $response->getStatusCode(), $response->getReasonPhrase()), PHP_EOL;
                        foreach ($response->getHeaders() as $name => $values) {
                            foreach ($values as $value) {
                                echo sprintf('< %s: %s', $name, $value), PHP_EOL;
                            }
                        }
                        echo '<', PHP_EOL;

                        $data = mb_substr($response->getBody()->read(min(1000, $response->getBody()->getSize())), 0, 100);
                        if ($response->getBody()->getSize() > 10 * 1024) {
                            echo sprintf('* Failure writing output to destination, returned %s.', $response->getBody()->getSize()), PHP_EOL;
                        } elseif (!mb_check_encoding($data, 'UTF-8')) {
                            echo '* Binary output can mess up your terminal.', PHP_EOL;
                        } else {
                            $response->getBody()->rewind();
                            echo sprintf('< %s', $response->getBody()->getContents()), PHP_EOL;
                            echo sprintf('* Connection #0 to host %s left intact', $request->getHeaderLine('Host')), PHP_EOL;
                        }
                        $response->getBody()->rewind();
                        echo PHP_EOL, PHP_EOL;
                    }

                    return $response;
                });
            };
        });

        return new HttpClient($config);
    }


    public function request(string $method,$uri = '',array $options = [],bool $is_check_success = true):Response{
        $response = new Response($this->getHttpClient()->requestLazy($method,$uri,$options));
        if($response->getCode() === null){
            throw new ServiceException($response, 'The interface response is incorrect.');
        }elseif($is_check_success &&!$response->isSuccess()){
            throw new ServiceException($response, sprintf('%s(%s)', $response->getMessage(), $response->getCode()));
        }
        return $response;
    }

     /**
     * @throws Throwable
     *
     * @return null|Response
     */
    public function tryRequest(string $method, $uri = '', array $options = [], $times = 3)
    {
        for ($i = 1; $i <= $times; $i++) {
            $response = $exception = null;

            try {
                $response = $this->request($method, $uri, $options);
                break;
            } catch (HttpClientException $exception) {
            }
        }

        if (isset($exception) && $exception instanceof Throwable) {
            throw $exception;
        }

        return $response ?? null;
    }
    
}
<?php

namespace Core\Enums;

/**
 * This enum provides list of mostly used HttpStatus for Response.
 * @author Shyam Dubey
 * @since 2025
 */
enum HttpStatus: string
{
    case OK = "200";
    case CREATED = "201";
    case ACCEPTED = "202";
    case NO_CONTENT = "204";
    case RESET_CONTENT = "205";
    case PARTIAL_CONTENT = "206";
    case ALREADY_REPORTED = "208";
    case FOUND = "302";
    case MOVED_PERMANENTLY = "301";
    case BAD_REQUEST = "400";
    case UNAUTHORIZED = "401";
    case PAYMENT_REQUIRED = "402";
    case FORBIDDEN = "403";
    case NOT_FOUND = "404";
    case METHOD_NOT_ALLOWED = "405";
    case NOT_ACCEPTABLE = "406";
    case REQUEST_TIMEOUT = "408";
    case URI_TOO_LONG = "414";
    case UNSUPPORTED_MEDIA_TYPE = "415";
    case INTERNAL_SERVER_ERROR = "500";
    case NOT_IMPLEMENTED = "501";
    case BAD_GATEWAY = "502";
    case SERVICE_UNAVAILABLE = "503";
    case GATEWAY_TIMEOUT = "504";
    case HTTP_VERSION_NOT_SUPPORTED = "505";
}

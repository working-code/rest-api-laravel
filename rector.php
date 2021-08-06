<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\SetList;
use Rector\Laravel\Set\LaravelSetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Rector\Laravel\Rector\Class_\AddMockConsoleOutputFalseToConsoleTestsRector;
use Rector\Laravel\Rector\ClassMethod\AddParentBootToModelClassMethodRector;
use Rector\Laravel\Rector\Assign\CallOnAppArrayAccessToStandaloneAssignRector;
use Rector\Laravel\Rector\MethodCall\ChangeQueryWhereDateValueWithCarbonRector;
use Rector\Laravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector;
use Rector\Laravel\Rector\New_\MakeTaggedPassedToParameterIterableTypeRector;
use Rector\Laravel\Rector\StaticCall\MinutesToSecondsInCacheRector;
use Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector;
use Rector\Laravel\Rector\StaticCall\Redirect301ToPermanentRedirectRector;
use Rector\Laravel\Rector\StaticCall\RequestStaticValidateToInjectRector;
use Rector\Laravel\Rector\New_\AddGuardToLoginEventRector;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();

    // Define what rule sets will be applied
    $containerConfigurator->import(LaravelSetList::LARAVEL_CODE_QUALITY);
    $containerConfigurator->import(LaravelSetList::LARAVEL_STATIC_TO_INJECTION);
    $containerConfigurator->import(LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL);
    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::CODE_QUALITY);

    // get services (needed for register a single rule)
    $services = $containerConfigurator->services();

    // register a single rule
    $services->set(TypedPropertyRector::class);
    $services->set(AddGuardToLoginEventRector::class);
    $services->set(AddMockConsoleOutputFalseToConsoleTestsRector::class);
    $services->set(AddParentBootToModelClassMethodRector::class);
    $services->set(CallOnAppArrayAccessToStandaloneAssignRector::class);
    $services->set(ChangeQueryWhereDateValueWithCarbonRector::class);
    $services->set(MakeTaggedPassedToParameterIterableTypeRector::class);
    $services->set(MinutesToSecondsInCacheRector::class);
    $services->set(HelperFuncCallToFacadeClassRector::class);
    $services->set(PropertyDeferToDeferrableProviderToRector::class);
    $services->set(Redirect301ToPermanentRedirectRector::class);
    $services->set(RequestStaticValidateToInjectRector::class);
//     $services->set(Option::SETS, [LaravelSetList::LARAVEL_60]);
};

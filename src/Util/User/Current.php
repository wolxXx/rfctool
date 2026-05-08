<?php

declare(strict_types = 1);

namespace RfcTool\Util\User;

class Current
{
    public static ?\RfcTool\Entity\User $forcedLoggedInUser = null;

    private static function getAuthSession(): \RfcTool\Util\Session
    {
        return \RfcTool\Util\Session::Factory(namespace: \RfcTool\Util\Session::NAMESPACE_APPLICATION);
    }

    public static function get(): ?\RfcTool\Entity\User
    {
        if (null !== static::$forcedLoggedInUser) {
            return static::$forcedLoggedInUser;
        }
        $session = static::getAuthSession()
                         ->get(what: \RfcTool\Util\Session::NAMESPACE_AUTH)
        ;
        if (null === $session) {
            return null;
        }
        if (true === $session instanceof \RfcTool\Entity\User) {
            return \RfcTool\Entity\User::getRepository()
                                       ->find(id: $session->getId())
            ;
        }

        return \RfcTool\Entity\User::getRepository()
                                   ->find(id: $session->user->id)
        ;
    }

    public static function logout(): void
    {
        static::getAuthSession()
              ->clear(what: \RfcTool\Util\Session::NAMESPACE_AUTH)
        ;
    }

    public static function login(\RfcTool\Entity\User $user): void
    {
        $userToStore           = new \stdClass();
        $userToStore->user     = new \stdClass();
        $userToStore->user->id = $user->getId();
        static::getAuthSession()
              ->write(what: \RfcTool\Util\Session::NAMESPACE_AUTH, data: $userToStore)
        ;

        /*if (true === $user->doNotifyLogin()) {
            \RfcTool\Util\Mailing\Login::send(worker: $user);
        }*/
        $user->setLastLogin(lastLogin: \Carbon\Carbon::now());
        $user::getRepository()
             ->update(entity: $user)
        ;
        \RfcTool\Util\DependencyContainer::getInstance()
                                         ->getEntityManager()
                                         ->flush()
        ;


        #\RfcTool\Util\FlashMessenger::addSuccess(message: \RfcTool\Util\DependencyContainer::getInstance()->getTranslator()->welcomeUser(\RfcTool\Util\View\Worker::get(worker: $user)));
    }

    public static function isAuthenticated(): bool
    {
        return true === static::get() instanceof \RfcTool\Entity\User;
    }

    public static function getLanguage(): string
    {
        return $_COOKIE['lang'] ?? \RfcTool\Util\Translator::LANGUAGE_GERMAN;
    }

    public static function setLanguage(?string $language): void
    {
        $_COOKIE['lang'] = $language;
    }

    public static function getLocale(): string
    {
        return match (static::getLanguage()) {
            \RfcTool\Util\Translator::LANGUAGE_ENGLISH => 'en_US',
            \RfcTool\Util\Translator::LANGUAGE_DEBUG   => 'xx',
            default                                    => 'de_DE',
        };
    }

}

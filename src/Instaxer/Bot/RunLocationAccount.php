<?php

namespace Instaxer\Bot;

class RunLocationAccount
{
    public function run()
    {
        try {
            $path = __DIR__ . '/../var/cache/instaxer/profiles/session.dat';

            $instaxer = new \Instaxer\Instaxer($path);
            $instaxer->login($array[1]['username'], $array[1]['password']);

            $locations = $instaxer->instagram->searchFacebookPlacesByLocation(53.431831, 14.553599);

            foreach ($locations->getItems() as $location) {

                $items = $instaxer->instagram->getLocationFeed($location->getLocation());

                echo sprintf('#%s: ' . "\r\n", $location->getTitle());

                foreach ($items->getItems() as $hashTagFeedItem) {

                    $id = $hashTagFeedItem->getId();
                    $user = $instaxer->instagram->getUserInfo($hashTagFeedItem->getUser())->getUser();
                    $followRatio = $user->getFollowerCount() / $user->getFollowingCount();

                    echo sprintf('User: %s; ', $user->getUsername());
                    echo sprintf('id: %s,  ', $id);
                    echo sprintf('followers: %s,  ratio: %s, ', $user->getFollowerCount(), round($followRatio, 1));

                    $instaxer->instagram->likeMedia($hashTagFeedItem->getID());
                    echo sprintf('[liked] ');

                    echo sprintf("\r\n");
                }
            }

        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }
}

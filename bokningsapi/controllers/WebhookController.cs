using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Hosting;
using System.IO;
using Microsoft.Extensions.Logging;
using bokningsapi.code;

namespace bokningsapi.controllers
{
    [ApiController]
    [Route("api/v1/webhooks")]
    public class WebhookController : ControllerBase
    {
        [HttpGet]
        [Route("bokning/subscribe")]
        public void SubscribeBooking(WebhookSubscription subscription)
        {
            _DataStore.SubscribeToWebhook("bokning", subscription);
        }

        [HttpGet]
        [Route("bokning/unsubscribe")]
        public void UnsubscribeBooking(string uri)
        {
            _DataStore.UnsubscribeToWebhook("bokning", uri);
        }
    }
}

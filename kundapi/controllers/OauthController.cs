using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Http;

namespace kundapi.controllers
{
    [ApiController]
    [Route("api/v1/oauth")]
    public class OauthController : ControllerBase
    {
        [HttpGet]
        [Route("unprotected")]
        public IHeaderDictionary Unprotected()
        {
            Console.WriteLine($"[{DateTime.Now.ToString()}] Request");
            foreach (var header in Request.Headers)
                Console.WriteLine($"{header.Key}: {header.Value}");
            return Request.Headers;
        }

        [HttpGet]
        [Route("protected")]
        [Authorize]
        public IHeaderDictionary Protected()
        {
            Console.WriteLine($"[{DateTime.Now.ToString()}] Request");
            foreach (var header in Request.Headers)
                Console.WriteLine($"{header.Key}: {header.Value}");
            return Request.Headers;
        }
    }
}

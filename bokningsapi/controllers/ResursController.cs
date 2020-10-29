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
    [Route("api/v1/resurs")]
    public class ResursController : ControllerBase
    {
        [HttpGet]
        [Route("lista")]
        public Resurs[] Lista()
        {
            return _DataStore.AllaResurser.ToArray();
        }

        [HttpGet]
        [Route("hamta")]
        public Resurs Hamta(string resursId)
        {
            return _DataStore.GetResurs(resursId);
        }

        [HttpPost]
        [Route("skapa")]
        public bool Skapa(Resurs resurs)
        {
            return _DataStore.TryAddResurs(resurs);
        }
    }
}

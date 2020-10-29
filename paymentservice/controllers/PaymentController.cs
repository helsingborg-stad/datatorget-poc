using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using paymentservice.Models;

namespace paymentservice.Controllers
{
    [ApiController]
    [Route("api/v1/payment")]
    public class PaymentController : ControllerBase
    {
        [HttpGet]
        [Route("get")]
        public bool Test(string paymentId)
        {
            return true;
        }
    }
}

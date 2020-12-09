using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Authorization;

namespace identitysvc.Controllers
{
    [ApiController]
    [Authorize]
    [Route("authtest")]
    public class AuthTestController : ControllerBase
    {
        [HttpGet]
        public IActionResult Default()
        {
            return new JsonResult(from c in User.Claims select new { c.Type, c.Value });
        }
    }
}

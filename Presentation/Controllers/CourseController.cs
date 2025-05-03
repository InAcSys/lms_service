using LMSService.Application.Services.Interfaces;
using LMSService.Domain.DTOs.Course;
using Microsoft.AspNetCore.Mvc;

namespace LMSService.Presentation.Controllers
{
    [ApiController, Route("api/[controller]")]
    public class CourseController(
        ICourseService courseService
    ) : ControllerBase
    {
        protected readonly ICourseService _courseService = courseService;

        [HttpGet]
        public async Task<IActionResult> GetAll(int pageNumber = 1, int pageSize = 10)
        {
            var response = await _courseService.GetAll(pageNumber, pageSize);
            if (response is null)
            {
                return NotFound();
            }
            return Ok(response);
        }

        [HttpGet("user-id/{id}")]
        public async Task<IActionResult> GetUserCoursesById(int id, int pageNumber = 1, int pageSize = 10)
        {
            var response = await _courseService.GetUserCoursesById(id, pageNumber, pageSize);
            if (response is null)
            {
                return NotFound();
            }
            return Ok(response);
        }

        [HttpPost]
        public async Task<IActionResult> Create(CreateCourseDTO course)
        {
            var response = await _courseService.Create(course);
            if (response is null)
            {
                return BadRequest(response);
            }
            return Ok(response);
        }
    }
}

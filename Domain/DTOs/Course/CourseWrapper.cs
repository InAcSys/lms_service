using System.Text.Json.Serialization;

namespace LMSService.Domain.DTOs.Course
{
    public class CourseWrapper
    {
        [JsonPropertyName("course")]
        public CreateCourseDTO Course { get; set; } = new();
    }
}
